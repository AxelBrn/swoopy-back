<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class SwoopyResponseFactory
{
    /**
     * @param array<string, string> $headers
     */
    public static function createSuccessResponse(mixed $data, int $statusCode, array $headers = []): Response
    {
        return new JsonResponse(
            self::createDataPayload($statusCode, $data),
            $statusCode,
            $headers
        );
    }

    /**
     * @param array<string, string> $headers
     */
    public static function createFailureResponse(\Throwable $throwable, int $statusCode, array $headers = []): Response
    {
        return new JsonResponse(
            self::createDataPayload($statusCode, null, $throwable),
            $statusCode,
            $headers
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function createDataPayload(int $statusCode, mixed $data, ?\Throwable $throwable = null): array
    {
        $data = [
            'code' => $statusCode,
            'status' => $statusCode >= 400 ? 'ERROR' : 'OK',
            'data' => $data,
        ];

        if (null !== $throwable) {
            unset($data['data']);
            $data['message'] = $throwable->getMessage();
            if ('dev' === $_ENV['APP_ENV']) {
                $data['stack'] = $throwable->getTrace();
            }
        }

        return $data;
    }
}
