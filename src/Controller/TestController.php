<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    #[Route('/api/v1/test', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $response = new JsonResponse();
        $data = [
            'data' => 'Hello World !'
        ];
        return $response->setData($data);
    }
}
