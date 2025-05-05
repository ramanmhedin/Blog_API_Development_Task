<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponse
{
    /**
     * Standard JSON response structure
     */
    protected function apiResponse(
        bool $success = true,
        string $message = '',
        mixed $data = null,
        int $statusCode = 200,
        mixed $errors = null
    ): JsonResponse {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if (!$success && $errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Success Response
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Operation successful',
        int $statusCode = 200
    ): JsonResponse {
        return $this->apiResponse(true, $message, $data, $statusCode);
    }

    /**
     * Error Response
     */
    protected function errorResponse(
        string $message = 'An error occurred',
        int $statusCode = 400,
        mixed $errors = null
    ): JsonResponse {
        return $this->apiResponse(false, $message, null, $statusCode, $errors);
    }

    /**
     * Common Responses (Aliases)
     */
    protected function createdResponse(mixed $data = null, string $message = 'Resource created'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    protected function validationErrorResponse(mixed $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    protected function serverErrorResponse(\Exception $e,string $message = 'Server Error', mixed $errors = null): JsonResponse
    {
        // Optionally log the error
        Log::error($message, [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'line' => $e->getLine()
        ]);
        return $this->errorResponse($message, 500, $errors);
    }
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }
}
