<?php

use Illuminate\Http\JsonResponse;

/**
 * Helper function to return JSON responses.
 *
 * @param string $message
 * @param array $data
 * @param int $statusCode
 * @return JsonResponse
 */
function jsonResponse(string $message,  mixed $data = [], int $statusCode = 200): JsonResponse
{
    return response()->json([
        'message' => $message,
        'data' => $data,
    ], status: $statusCode);
}
