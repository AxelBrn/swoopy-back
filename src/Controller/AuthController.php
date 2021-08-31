<?php

namespace App\Controller;

use App\Dto\AuthDto;
use App\Models\RefreshCookie;
use App\Models\ResponseModel;
use App\Repository\UserRepository;
use App\Utils\JwtUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
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
     * Authentication End-point
     * @Route("", name="login", methods={"POST"})
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
        $response = new ResponseModel(null, Response::HTTP_NOT_FOUND, 'Invalid credentials');
        if ($authDto->isBuild()) {
            $user = $userRepository->findOneBy(['username' => $authDto->username]);
            if ($user != null && password_verify($authDto->password, $user->getPassword()) === true) {
                $response->headers->setcookie(JwtUtils::generateRefreshCookie($user));
                $response->setStatusCode(Response::HTTP_OK);
                $response->setData([
                    'token' => JwtUtils::generateAccessToken($user),
                ]);
                $response->setMessage("Authentication Successfully");
            }
        }
        return $response;
    }

    /**
     * Refresh your access token
     * @Route("/refresh", name="refresh_token", methods={"POST"})
     * 
     * @return Response
     */
    public function refresh(RefreshCookie $refreshCookie): Response
    {
        $response = new ResponseModel(null, Response::HTTP_NOT_FOUND, 'No token found');
        $user = $refreshCookie->getUser();
        if ($user !== null && $refreshCookie->isValid()) {
            $response->headers->setcookie(JwtUtils::generateRefreshCookie($user));
            $response->setData(['token' => JwtUtils::generateAccessToken($user)]);
            $response->setStatusCode(Response::HTTP_OK);
            $response->setMessage('Token successfully refresh');
        }
        return $response;
    }

    /**
     * Delete refresh cookie
     * @Route("/logout", name="logout", methods={"GET"})
     * 
     * @return Response
     */
    public function logout(): Response
    {
        $response = new ResponseModel(null, Response::HTTP_OK, 'Logout Successfully');
        $response->headers->clearCookie("refreshToken");
        return $response;
    }
}
