<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use Jenssegers\Mongodb\Relations\HasOne;
use Jenssegers\Mongodb\Relations\BelongsTo;
use App\Models\Kendaraan;
use App\Models\User;

class Produk extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'produks';

    protected $fillable = [
        'produk_id', 
        'produk_kategori', 
        'produk_judul', 
        'produk_deskripsi', 
        'produk_foto', 
        'produk_pemasang',
        'kontak_pemasang',
        'lokasi_provinsi', 
        'lokasi_kabupaten_kota', 
        'lokasi_kecamatan', 
        'lokasi_koordinat', 
        'date_posted'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'produk_pemasang', 'username');
    }

    public function kendaraan(): HasOne
    {
        return $this->hasOne(Kendaraan::class, 'produk_id', 'produk_id');
    }
}
