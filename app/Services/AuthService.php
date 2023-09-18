<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\FileRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use MongoDB\Exception\InvalidArgumentException;
use App\Exceptions\ArrayException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthService
{
    protected $authRepository;
    protected $produkRepository;
    protected $fileRepository;

    public function __construct(AuthRepository $authRepository, ProdukRepository $produkRepository, FileRepository $fileRepository)
    {
        $this->authRepository = $authRepository;
        $this->produkRepository = $produkRepository;
        $this->fileRepository = $fileRepository;
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

        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        if ((filter_var($data['email'], FILTER_VALIDATE_EMAIL)) !== false) {
            // okay, should be valid now
            $data['verified_time'] = (string)Carbon::now('+7:00');
            $data['username'] = substr($data['email'], 0, strrpos($data['email'], '@'));
        } else { throw new InvalidArgumentException('invalid email'); }

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

        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

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
     * Update user profile data
     */
    public function update(array $data): Object
    {
        $validator = Validator::make($data, [
            // 'username' => 'required|string',
            'new_username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore(auth()->user()['username'], 'username')],
            'full_name' => 'nullable|string',
            'about' => 'nullable|string',
            'phone_number' => 'required|string'
        ], [
            'new_username.unique' => 'username already taken'
        ]);

        // $user = $this->authRepository->getByUsername($data['username']);
        $user = $this->authRepository->getByUsername(auth()->user()['username']);

        if (!$user) { throw new InvalidArgumentException('user not found'); }
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $data['username'] = auth()->user()['username'];

        $produk = true;
        while ($produk == true) {
            $produk = $this->produkRepository->updateUsername($data['username'], $data['new_username']);
        }

        $file = true;
        while ($file == true) {
            $file = $this->fileRepository->updateUsername($data['username'], $data['new_username']);
        }

        $user = $this->authRepository->save($data);
        return $user;
    }

    /**
     * Update user email
     */
    public function updateEmail(array $data): Object
    {
        $validator = Validator::make($data, [
            // 'username' => 'required|string',
            'password' => 'required|string',
            'new_email' => 'required|string|email|max:255|unique:users',
        ], [
            'new_email.unique' => 'email already registered'
        ]);

        // $user = $this->authRepository->getByUsername($data['username']);
        $user = $this->authRepository->getByUsername(auth()->user()['username']);

        if (!$user) { throw new InvalidArgumentException('user not found'); }
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }
        if ((filter_var($data['new_email'], FILTER_VALIDATE_EMAIL)) !== false) {
            // okay, should be valid now
            $data['verified_time'] = (string)Carbon::now('+7:00');
        } else { throw new InvalidArgumentException('invalid email'); }
        if (Hash::check($data['password'], $user->password, []) == false) { 
            throw new InvalidArgumentException('password incorrect');
        }

        $data['username'] = auth()->user()['username'];
        $user = $this->authRepository->saveEmail($data);
        return $user;
    }

    /**
     * Update user password
     */
    public function updatePassword(array $data): Object
    {
        $validator = Validator::make($data, [
            // 'username' => 'required|string',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ]);

        // $user = $this->authRepository->getByUsername($data['username']);
        $user = $this->authRepository->getByUsername(auth()->user()['username']);
        
        if (!$user) { throw new InvalidArgumentException('user not found'); }
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }
        if (Hash::check($data['old_password'], $user->password, []) == false) { 
            throw new InvalidArgumentException('password incorrect');
        }

        $data['username'] = auth()->user()['username'];
        $user = $this->authRepository->savePassword($data);
        return $user;
    }

    /**
     * Upload user profile picture
     */
    public function uploadPhoto(array $data): array
    {
        $validator = Validator::make($data, [
            // 'username' => 'required|string',
            'profile_picture' => 'required|mimes:jpg,jpeg,png|max:10000',
        ], [
            'profile_picture.required' => 'Please upload a file',
            'profile_picture.mimes' => 'Only jpg, jpeg, and png images are allowed',
            'profile_picture.max' => 'Sorry! Maximum allowed size for a file is 10MB',
        ]);

        // $user = $this->authRepository->getByUsername($data['username']);
        $user = $this->authRepository->getByUsername(auth()->user()['username']);
        
        if (!$user) { throw new InvalidArgumentException('user not found'); }
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $data['file_name'] = date('Y-m-d H-i-s ') . pathinfo($data['profile_picture']->getClientOriginalName(), PATHINFO_FILENAME) .
                                                            "." . $data['profile_picture']->getClientOriginalExtension();
        $data['file_category'] = 'profile';
        $data['posted_by'] = auth()->user()['username'];
        $data['created_at'] = (string)Carbon::now('+7:00')->format('Y-m-d H-i-s');

        $data['username'] = auth()->user()['username'];
        $user = $this->authRepository->savePhoto($data['username'], $data['profile_picture']->getClientOriginalName());
        $file = $this->fileRepository->uploadProfilePicture($data);

        $info = [
            'user_data' => $user->toArray(),
            'photo_data' => $file->toArray()
        ];
        return $info;
    }

    /**
     * Download or get user profile picture
     */
    public function downloadPhoto(string $username)
    {
        $user = $this->authRepository->getByUsername($username);
        if (!$user) { throw new InvalidArgumentException('user not found'); }
        if ($user->profile_picture == null) { return null; }

        $photo = $this->fileRepository->downloadProfilePicture(auth()->user()['username']);
        return $photo;
    }

    /**
     * Delete user profile picture
     */
    public function deletePhoto(): string
    {
        // $user = $this->authRepository->getByUsername($username);
        $user = $this->authRepository->getByUsername(auth()->user()['username']);
        if (!$user) { throw new InvalidArgumentException('user not found'); }

        if ($user->profile_picture == null) { return 'Profile picture do not exist'; }

        $this->fileRepository->deleteProfilePicture(auth()->user()['username']);
        $user = $this->authRepository->deletePhoto(auth()->user()['username']);

        return $user;
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
