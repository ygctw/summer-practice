<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $encoder;
    private $userRepository;
    private $session;

    /**
     * UserService constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param UserRepository $userRepository
     * @param SessionInterface $session
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        UserRepository $userRepository,
        SessionInterface $session)
    {
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @param $email
     * @param $password
     * @return UsernamePasswordToken|null
     */
    public function login($email, $password): ?UsernamePasswordToken
    {
        if ($user = $this->userRepository->findOneBy(['email' => $email])) {
            if ($this->encoder->isPasswordValid($user, $password)) {
                return $this->createToken($email, $password);
            }
        }
        return null;

    }

    public function register($email, $password): bool
    {
        if ($this->userRepository->findOneBy(['email' => $email])) {
            return false;
        }
        $user = $this->userRepository->createUser($email, '');
        $password = $this->encoder->encodePassword($user, $password);
        $user->setPassword($password);
        $this->userRepository->saveUser($user);
        return true;

    }

    /**
     * @param $email
     * @param $password
     * @return UsernamePasswordToken
     */
    protected function createToken($email, $password)
    {
        $token = new UsernamePasswordToken($email, $password, User::class);
        $this->session->set('token', $token);
        return $token;
    }

    protected function getTokenFromSession()
    {
        return $this->session->get('token');
    }
}