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
        $file = new $this->file;

        $data['profile_picture']->storeAs("/profile/", $data['file_name']);
        $file->file_name = $data['file_name'];
        $file->file_category = $data['file_category'];
        $file->posted_by = $data['posted_by'];
        $file->created_at = $data['created_at'];

        $file->save();
        return $file->fresh();
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
}