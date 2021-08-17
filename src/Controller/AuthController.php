<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/api/v1/auth", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $user = $this->getUser();
        print_r($user);

        return $this->json([
            // The getUserIdentifier() method was introduced in Symfony 5.3.
            // In previous versions it was called getUsername()
            'username' => $user->getUserIdentifier(),
            'id' => $user->getId(),
            'roles' => $user->getRoles(),
        ]);
    }

    /**
     * @Route("/api/v1/test", name="login", methods={"GET"})
     */
    public function test(): Response
    {
        return $this->json([
            // The getUserIdentifier() method was introduced in Symfony 5.3.
            // In previous versions it was called getUsername()
            'username' => 'AxelBrn',
        ]);
    }
}
