<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Carbon\Carbon;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Untuk mengambil semua list user
     */
    public function getAll() : ?Object
    {
        $users = $this->authRepository->getAll();
        $user = $users->isEmpty() ? null : $users;
        return $user;
    }

    /**
     * Untuk menambahkan user
     */
    public function store(array $data) : Object
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if ((filter_var($data['email'], FILTER_VALIDATE_EMAIL)) !== false) {
            // okay, should be valid now
            $data['verified_time'] = (string)Carbon::now('+7:00');
            $data['username'] = substr($data['email'], 0, strrpos($data['email'], '@'));
        }

        $result = $this->authRepository->store($data);
        return $result;
    }

    /**
     * Untuk melakukan login user dengan data yang diperlukan
     */
    public function login(array $credentials) : string|bool
    {        
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }        

        $token = auth()->attempt($credentials, true);

        return $token;
    }

    /**
     * Untuk melihat detail user yang telah dalam keadaan logged in
     */
    public function data() : array
    {
        $user = auth()->user();
        return $user->only(['email', 'username', 'full_name', 'about', 'phone_number', 'profile_picture']);
    }

    /**
     * Untuk melakukan logout pada user
     */
    public function logout() : string
    {
        $username = auth()->user()['username'];
        auth()->logout();
        return $username;
    }
}
