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

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Log in a user to the system",
     *     tags={"Auth"},
     *     description="This endpoint allows a user to log in by providing their credentials (email and password).",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="test@example.com", description="The email address of the user."),
     *             @OA\Property(property="password", type="string", format="password", example="password", description="The password of the user (minimum length: 8 characters).")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1..."),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="user@example.com"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05 11:45:14"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05 11:45:14")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="false"),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password must be at least 8 characters.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="false"),
     *             @OA\Property(property="message", type="string", example="An error occurred while processing the request.")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     description="Registers a user with name, email, and password.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="registered successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05 11:45:14"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05 11:45:14")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while processing the request.")
     *         )
     *     )
     * )
     */

    public function register(Request $request,AuthService $authService): JsonResponse
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

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Log out the authenticated user",
     *     tags={"Auth"},
     *     description="Logs out the currently authenticated user and invalidates their token.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged out"),
     *             @OA\Property(property="data", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred while processing the request.")
     *         )
     *     )
     * )
     */

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
