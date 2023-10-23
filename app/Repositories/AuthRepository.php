<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    protected $users;

    public function __construct(User $user)
    {
        $this->users = $user;
    }

    /**
     * Untuk mengambil semua list user
     */
    public function getAll() : Object
    {
        $users = $this->users->get();
        return $users;
    }

    /**
     * Untuk mengambil data user berdasarkan username
     */
    public function getByUsername(string $username) : ?Object
    {
        $user = $this->users->where('username', $username)->first();
        return $user;
    }

    /**
     * Untuk menyimpan data user baru
     */
    public function store(array $data) : Object
    {
        $userBaru = new $this->users;

        $userBaru->email = $data['email'];
        $userBaru->username = $data['username'];
        $userBaru->full_name = '';
        $userBaru->email_verified_at = $data['verified_time'];
        $userBaru->password = bcrypt($data['password']);
        $userBaru->about = '';
        $userBaru->phone_number = '';
        $userBaru->profile_picture = null;

        $userBaru->save();
        return $userBaru->fresh();
    }

    /**
     * Untuk memperbarui data user
     */
    public function save(array $data) : Object
    {
        $user = $this->getByUsername($data['username']);

        $user->username = $data['new_username'];
        $user->full_name = $data['full_name'];
        $user->about = $data['about'];
        $user->phone_number = $data['phone_number'];

        $user->save();
        return $user->fresh();
    }
    
    /**
     * Update user email
     */
    public function saveEmail(array $data): Object
    {
        $user = $this->getByUsername($data['username']);

        $user->email = $data['new_email'];
        $user->email_verified_at = $data['verified_time'];

        $user->save();
        return $user->fresh();
    }

    /**
     * Update user password
     */
    public function savePassword(array $data): Object
    {
        $user = $this->getByUsername($data['username']);

        $user->password = bcrypt($data['new_password']);

        $user->save();
        return $user->fresh();
    }

    /**
     * Upload user profile picture
     */
    public function savePhoto(string $username, string $fileName): Object
    {
        $user = $this->getByUsername($username);

        $user->profile_picture = $fileName;

        $user->save();
        return $user->fresh();
    }

    /**
     * Delete user profile picture
     */
    public function deletePhoto(string $username): string
    {
        $user = $this->getByUsername($username);

        $user->profile_picture = null;

        $user->save();
        return "profile picture of ". $user->username . " removed";
    }

    /**
     * Untuk menghapus data user berdasarkan id
     */
    public function delete(string $id) : void
    {
        $this->users->where('_id', $id)->delete();
    }
}
