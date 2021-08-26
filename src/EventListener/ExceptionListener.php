<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new Response();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $message = [
            'status' => 'ERROR',
            'message' => $exception->getMessage(),
            'code' => $response->getStatusCode(),
        ];

        if ($_ENV['APP_ENV'] === 'dev') {
            $message['stack'] = $exception->getTrace();
        }

        $response->setContent(json_encode($message));
        $event->setResponse($response);
    }
}