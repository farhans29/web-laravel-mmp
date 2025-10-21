<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class AuthController extends Controller
{
    /**
     * Validate the auth request data
     */
    protected function validateAuth(Request $request, string $type): array
    {
        $rules = [];

        switch ($type) {
            case 'login':
                $rules = [
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8'],
                ];
                break;
            case 'register':
                $rules = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ];
                break;
        }

        return $request->validate($rules);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="1|abcdefghijklmnopqrstuvwxyz"),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateAuth($request, 'login');
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials)) {
                return $this->errorResponse(
                    'Invalid credentials',
                    HttpStatus::HTTP_UNAUTHORIZED
                );
            }

            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]
            ]);
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Login failed',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateAuth($request, 'register');

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            return response()->json([
                'data' => $user
            ], HttpStatus::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Registration failed',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="User logout",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID of the user to logout")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - Token does not belong to the user"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $authenticatedUser = $request->user();
            $requestedUserId = $validated['user_id'];

            // If user is authenticated, perform security checks and token cleanup
            if ($authenticatedUser) {
                // Security check: Ensure the token belongs to the user being logged out
                if ($authenticatedUser->id !== (int)$requestedUserId) {
                    return $this->errorResponse(
                        'Forbidden: Token does not belong to the specified user',
                        HttpStatus::HTTP_FORBIDDEN
                    );
                }

                // Enhanced security: Delete all tokens for the user (prevents token replay attacks)
                // This is better than just deleting current token as it invalidates all sessions
                $authenticatedUser->tokens()->delete();
            } else {
                // If no authenticated user, try to find the user by user_id and logout
                $user = \App\Models\User::find($requestedUserId);
                if ($user) {
                    // Delete all tokens for the specified user
                    $user->tokens()->delete();
                }
            }

            return response()->json([
                'message' => 'Logged out successfully',
                'user_id' => $requestedUserId
            ]);
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                HttpStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Logout failed',
                HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                $e
            );
        }
    }

    /**
     * Format error response
     */
    private function errorResponse(
        string $message,
        int $statusCode,
        ?\Throwable $exception = null,
        array $additional = []
    ): JsonResponse {
        $response = [
            'message' => $message,
            'status' => $statusCode,
        ];

        if (config('app.debug') && $exception) {
            $response['debug'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        return response()->json(
            array_merge($response, $additional),
            $statusCode
        );
    }
}