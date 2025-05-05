<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(Request $request,AuthService $authService): JsonResponse
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        try {
            $data = $authService->login($request);
            return $this->successResponse($data, 'Login successful');

        }catch (ValidationException $validationException){
            return $this->validationErrorResponse(
                $validationException->errors(),
                $validationException->getMessage());

        }catch( \Exception $exception){
            return $this->serverErrorResponse($exception);
        }
    }

    public function register(Request $request,AuthService $authService)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        try {
            $data=$authService->register($request);
            return $this->successResponse($data, 'registered successful');

        }catch( \Exception $exception){
            return $this->serverErrorResponse($exception);
        }
    }

    public function logout(Request $request,AuthService $authService): JsonResponse
    {
        try {
            $authService->logout($request);
            return $this->successResponse(null, 'Successfully logged out');

        }catch( \Exception $exception){
            return $this->serverErrorResponse($exception);
        }
    }
}
