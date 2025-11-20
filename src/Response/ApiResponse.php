<?php

namespace App\Response;

class ApiResponse
{
    /**
     * Return a successful JSON response structure.
     */
    public static function success(array $payload): array
    {
        return array_merge([
            'success' => true,
            'errors'  => null,
        ], $payload);
    }

    /**
     * Return a standardized error JSON structure.
     */
    public static function error(string $message, int $code): array
    {
        return [
            'success' => false,
            'errors'  => $message,
            'status'  => $code,
            'domain'  => null,
            'records' => null,
        ];
    }
}
