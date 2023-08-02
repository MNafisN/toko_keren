<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class File extends Model
{
    public $timestamps = false;

    protected $connection = 'mongodb';
    protected $collection = 'files';

    protected $fillable = [
        'file_name',
        'file_category',
        'posted_by',
        'created_at'
    ];
}
