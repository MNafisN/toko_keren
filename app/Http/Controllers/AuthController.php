<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authService = $authService;
    }

    /**
     * Register a new user
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        $data = $request->only('username', 'email', 'password', 'first_name', 'last_name');

        try {
            $user = $this->authService->store($data);
            return response()->json([
                'status' => 201,
                'message' => 'User registered successfully',
                'registered_user' => $user->only(['name', 'email'])
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Log in and get a JWT token via given credentials
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            $token = $this->authService->login($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 401,
                    'error' => 'Unauthorized'
                ], 401);
            }
    
            return response()->json([
                'status' => 200,
                'logged_in_user' => [
                    'name' => auth()->user()['first_name'],
                    'email' => auth()->user()['email']
                ],
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Get current logged in user's data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data() : JsonResponse
    {
        return response()->json([
            'logged_in_user' => $this->authService->data()
        ], 200);
    }

    /**
     * Get a new JWT token for the logged in user
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function refresh() : JsonResponse
    {
        return response()->json([
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() : JsonResponse
    {
        $message = $this->authService->logout().' Successfully logged out';

        return response()->json([
            'message' => $message
        ], 200);
    }
}
