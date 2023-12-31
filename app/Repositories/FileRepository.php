<?php

namespace App\Repositories;

use App\Models\File;

use Illuminate\Support\Facades\Storage;

class FileRepository
{
    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function uploadProfilePicture(array $data): Object
    {
        $file = $this->file->where([
            ['file_category', 'profile'],
            ['posted_by', $data['username']]
        ])->first();

        if (!$file) { $file = new $this->file; }
        else { Storage::disk('public')->delete(("/profile/" . $file->file_name)); }

        $data['profile_picture']->storeAs("/profile/", $data['file_name']);
        $file->file_name = $data['file_name'];
        $file->file_category = $data['file_category'];
        $file->posted_by = $data['posted_by'];
        $file->created_at = $data['created_at'];

        $file->save();
        return $file->fresh();
    }

    public function downloadProfilePicture(string $username)
    {
        $file = $this->file->where([
            ['file_category', 'profile'],
            ['posted_by', $username]
        ])->first();

        $fileName = $file->file_name; // $file->created_at . " " . 
        return Storage::download("/profile/" . $fileName, $fileName);
    }

    public function deleteProfilePicture(string $username): void 
    {
        $file = $this->file->where([
            ['file_category', 'profile'],
            ['posted_by', $username]
        ])->first();

        $fileName = $file->file_name; // $file->created_at . " " . 
        Storage::disk('public')->delete(("/profile/" . $fileName));
        $file->delete();
    }

    public function updateUsername(string $oldUsername, string $newUsername): bool
    {
        $file = $this->file->where([
            ['posted_by', $oldUsername]
        ])->first();
        if (!$file) { return false; }

        $file->posted_by = $newUsername;
        
        $file->save();
        return true;
    }

    public function getPhotoByName(string $name): ?Object
    {
        $file = $this->file->where([
            ['file_category', 'produk'],
            ['file_name', 'LIKE', '%'.$name.'%']
        ])->first();

        return $file;
    }

    public function uploadPhoto(array $data): Object
    {
        $file = new $this->file;

        $data['photo']->storeAs("/produk/", $data['file_name']);
        $file->file_name = $data['file_name'];
        $file->file_category = $data['file_category'];
        $file->posted_by = $data['posted_by'];
        $file->created_at = $data['created_at'];

        $file->save();
        return $file->fresh();
    }

    public function downloadPhoto(string $fileName)
    {
        $file = $this->getPhotoByName($fileName);

        $fileName = $file->file_name;
        return Storage::download("/produk/" . $fileName, $fileName);
    }

    public function deletePhoto(string $fileName): string
    {
        $file = $this->getPhotoByName($fileName);

        $fileName = $file->file_name;
        Storage::disk('public')->delete(("/produk/" . $fileName));
        $file->delete();

        return $fileName;
    }
}