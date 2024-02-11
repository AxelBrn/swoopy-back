<?php

namespace App\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class SwoopyResponseFactory {

    /**
     * @param mixed $data
     * @param int $statusCode
     * @param array<string, string> $headers
     * @return Response
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
     * @param Throwable $throwable
     * @param int $statusCode
     * @param array<string, string> $headers
     * @return Response
     */
    public static function createFailureResponse(Throwable $throwable, int $statusCode, array $headers = []): Response
    {
        return new JsonResponse(
            self::createDataPayload($statusCode, null, $throwable),
            $statusCode,
            $headers
        );
    }

    /**
     * @param int $statusCode
     * @param mixed $data
     * @param null|Throwable $throwable
     * @return array<string, mixed>
     */
    public static function createDataPayload(int $statusCode, mixed $data, ?Throwable $throwable = null): array
    {
        $data = [
            'code' => $statusCode,
            'status' => $statusCode >= 400 ? 'ERROR': 'OK',
            'data' => $data
        ];

        if ($throwable !== null) {
            unset($data['data']);
            $data['message'] = $throwable->getMessage();
            if ($_ENV['APP_ENV'] === 'dev') {
                $data['stack'] = $throwable->getTrace();
            }
        }
        return $data;
    }
}
