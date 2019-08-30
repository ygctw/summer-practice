<?php


namespace App\Command;

use App\Entity\AbstractYandexEntity;
use App\Entity\Region;
use App\Entity\Settlement;
use App\Entity\Station;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetFromYandexCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:get-data';

    private $entityManager;


    /**
     * GetFromYandexCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }


    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Get data from Yandex api');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Get stations');
        $client = new Client();
        try {
            $res = $client->request('GET', 'https://api.rasp.yandex.net/v3.0/stations_list/', [
                'query' => ['apikey' => 'ef3a3e89-de38-4c07-80e0-2982d6b29815', 'format' => 'json', 'lang' => 'ru_RU']
            ]);
            $res = json_decode($res->getBody(), true);
            foreach ($res['countries'] as $country) {
                if ($country['title'] === 'Россия') {
                    foreach ($country['regions'] as $region) {
                        if ($region['title'] && $region['codes']['yandex_code']) {
                            $regionEntity = $this->createEntity(Region::class, $region);
                            foreach ($region['settlements'] as $settlement) {
                                if ($settlement['title'] && $settlement['codes']['yandex_code']) {
                                    $settlementEmtity = $this->createEntity(Settlement::class, $settlement, $regionEntity);
                                    foreach ($settlement['stations'] as $station) {
                                        if ($station['title'] && $station['codes']['yandex_code']) {
                                            $this->createEntity(Station::class, $station, $settlementEmtity);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (GuzzleException $e) {
        }
    }

    /**
     * @param string $class
     * @param array $array
     * @param AbstractYandexEntity|null $relationEntity
     * @return AbstractYandexEntity
     */
    protected function createEntity(string $class, array $array, AbstractYandexEntity $relationEntity = null)
    {
        $repository = $this->entityManager->getRepository($class);
        /**
         * @var AbstractYandexEntity $entity
         */
        if ($entity = $repository->findOneBy(['code' => $array['codes']['yandex_code']])) {
            $entity->setCode($array['codes']['yandex_code'])
                ->setTitle($array['title'])
                ->setRelation($relationEntity);


        } else {
            $entity = new $class();
            $entity->setCode($array['codes']['yandex_code'])
                ->setTitle($array['title'])
                ->setRelation($relationEntity);
        }
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }
}