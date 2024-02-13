<?php

namespace App\EventListener;

use App\Factory\SwoopyResponseFactory;
use App\Service\SwoopyTokenManagerService;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\Response;

class AuthListener
{
    private SwoopyTokenManagerService $swoopyTokenManagerService;

    public function __construct(SwoopyTokenManagerService $swoopyTokenManagerService)
    {
        $this->swoopyTokenManagerService = $swoopyTokenManagerService;
    }

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event): void
    {
        $event->setResponse(
            SwoopyResponseFactory::createFailureResponse(
                $event->getException(),
                Response::HTTP_UNAUTHORIZED
            )
        );
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $event->setData($this->swoopyTokenManagerService->modifyTokenPayload(
            $event->getUser(),
            $event->getData()
        ));
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $event->getResponse()->headers->setCookie($this->swoopyTokenManagerService->createRefreshTokenCookie($event->getUser()));
        $event->setData(SwoopyResponseFactory::createDataPayload(
            $event->getResponse()->getStatusCode(),
            $event->getData()['token']
        ));
    }
}
