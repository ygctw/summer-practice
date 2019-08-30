<?php

namespace App\Controller;


use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        if ($this->userService->login($request->get('email'), $request->get('password'))) {
            return new JsonResponse([
                'success' => true
        ]);
        }

        return new JsonResponse([
            'success' => false
        ]);
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        return new JsonResponse([
            'success' => $this->userService->register($request->get('email'), $request->get('password'))
        ]);
    }
}