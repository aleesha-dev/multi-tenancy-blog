<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendPasswordResetLinkRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function __construct(public AuthService $authService) {}


    /**
     * Login API
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$this->attemptLogin($request)) {
            return $this->unauthorizedResponse();
        }

        $user = Auth::user();
        $token = $this->generateToken($user);

        return $this->successResponse($token, $user);
    }

    /**
     * Attempt to log in the user.
     *
     * @param LoginRequest $request
     * @return bool
     */
    protected function attemptLogin(LoginRequest $request): bool
    {
        return Auth::attempt($request->only('email', 'password'));
    }

    /**
     * Generate a token for the authenticated user.
     *
     * @param $user
     * @return string
     */
    protected function generateToken($user): string
    {
        return $user->createToken('Tenants')->accessToken;
    }

    /**
     * Prepare a successful login response.
     *
     * @param string $token
     * @param $user
     * @return JsonResponse
     */
    protected function successResponse(string $token, $user): JsonResponse
    {
        return jsonResponse(
            message: __('auth.login_success'),
            data: [
                'token' => $token,
                'user' => $user
            ],
            statusCode: 200
        );
    }

    /**
     * Prepare an unauthorized response.
     *
     * @return JsonResponse
     */
    protected function unauthorizedResponse(): JsonResponse
    {
        return jsonResponse(
            message: __('auth.unauthorized'),
            data: [],
            statusCode: 401
        );
    }

}
