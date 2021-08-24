<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\JwtUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

    /**
     * @Route("/api/v1/auth", name="login", methods={"POST"})
     * @param Request $request
     * 
     * @return Response
     */
    public function auth(Request $request, UserRepository $userRepository): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user != null && password_verify($password, $user->getPassword()) === true) {
            return $this->json([
                'token' => JwtUtils::generateAccessToken($user),
            ], 200);
        }
        return $this->json([
            "message" => 'Invalid credentials'
        ], 404);
    }

    /**
     * @Route("/api/v1/test", name="test", methods={"GET"})
     * 
     * @return Response
     */
    public function test(): Response {
        return $this->json([
            'test' => true
        ]);
    }
}
