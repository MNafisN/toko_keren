<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ArrayException;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;
    
    public function __construct(AuthService $authService)
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
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
        $data = $request->all();

        try {
            $user = $this->authService->store($data);
            $result = [
                'status' => 201,
                'message' => 'User registered successfully',
                'registered_user' => $user->only(['username', 'email'])
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
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
        $credentials = $request->all();

        try {
            $token = $this->authService->login($credentials);
            if (!$token) { return response()->json(['status' => 401, 'error' => 'Wrong email or password, please try again'], 401); }

            $result = [
                'status' => 200,
                'logged_in_user' => [
                    'username' => auth()->user()['username'],
                    'email' => auth()->user()['email']
                ],
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Get current logged in user's data, for edit profile form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data() : JsonResponse
    {
        $result = [
            'status' => 200,
            'user_data' => $this->authService->data()
        ];

        return response()->json($result, $result['status']);
    }

    /**
     * Update user profile data
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $result = [
                'status' => 200,
                'message' => 'user updated successfully',
                'data' => $this->authService->update($data)
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update user email
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $result = [
                'status' => 200,
                'message' => 'user email updated successfully',
                'data' => $this->authService->updateEmail($data)
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update user password
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $result = [
                'status' => 200,
                'message' => 'user password updated successfully',
                'data' => $this->authService->updatePassword($data)
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Upload user profile picture
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $result = [
                'status' => 200,
                'message' => 'user profile picture uploaded successfully',
                'info' => $this->authService->uploadPhoto($data)
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Delete user profile picture
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePhoto(): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'message' => $this->authService->deletePhoto()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Get a new JWT token for the logged in user
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function refresh() : JsonResponse
    {
        $result = [
            'status' => 200,
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return response()->json($result, $result['status']);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() : JsonResponse
    {
        $message = $this->authService->logout().' Successfully logged out';

        $result = [
            'status' => 200,
            'message' => $message
        ];

        return response()->json($result, $result['status']);
    }
}
