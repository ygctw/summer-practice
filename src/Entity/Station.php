<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationRepository")
 */
class Station extends AbstractYandexEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $code;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Settlement", inversedBy="stations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $settlement;


    public function getSettlement(): ?Settlement
    {
        return $this->settlement;
    }

    public function setSettlement(?Settlement $settlement): self
    {
        $this->settlement = $settlement;

        return $this;
    }

    public function setRelation(AbstractYandexEntity $entity = null)
    {
        $this->settlement = $entity;
        return $this;
    }
}
