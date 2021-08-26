<?php

namespace App\Controller;

use App\Dto\AuthDto;
use App\Repository\UserRepository;
use App\Utils\JwtUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\JsonContent;

/**
 * @Route("/api/v1/auth", format="json")
 * @OA\Tag(name="Auth")
 */
class AuthController extends AbstractController
{

    /**
     * @Route("", name="login", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param AuthDto $authDto
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         ref=@Model(type=AuthDto::class),
     *     )
     * )
     * @return Response
     */
    public function auth(UserRepository $userRepository, AuthDto $authDto): Response
    {
        $response = $this->json([
            "message" => 'Invalid credentials'
        ], 404);
        if ($authDto->isBuild()) {
            $user = $userRepository->findOneBy(['username' => $authDto->username]);
            if ($user != null && password_verify($authDto->password, $user->getPassword()) === true) {
                $response = $this->json([
                    'token' => JwtUtils::generateAccessToken($user),
                ], 200);
            }
        }
        return $response;
    }
}
