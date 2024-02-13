<?php

namespace App\Controller;

use App\Factory\SwoopyResponseFactory;
use App\Service\SwoopyTokenManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends AbstractController
{
    #[Route('/api/login/refresh', methods: ['POST'])]
    public function refresh(Request $request, SwoopyTokenManagerService $JWTManager): Response
    {
        $cookieToken = $request->cookies->getString('refresh_token');
        $bodyToken = $request->request->getString('refresh_token');

        if (0 === strlen($cookieToken) && 0 === strlen($bodyToken)) {
            throw new BadRequestHttpException('refresh_token is required and cannot have empty value');
        }

        $refreshTokenFromRequest = strlen($cookieToken) > 0 ? $cookieToken : $bodyToken;
        try {
            $user = $JWTManager->getUserFromRefreshToken($refreshTokenFromRequest);
        } catch (AuthenticationException $exception) {
            throw new UnauthorizedHttpException('', $exception->getMessageKey());
        }

        if (null === $user) {
            throw new BadRequestHttpException('Not a valid user in Refresh Token');
        }

        return SwoopyResponseFactory::createSuccessResponse(
            $JWTManager->createAccessToken($user),
            Response::HTTP_OK,
            ['set-cookie' => $JWTManager->createRefreshTokenCookie($user)]
        );
    }
}
