<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use App\Models\Penjualan;

class Kendaraan extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'kendaraans';
    protected $fillable = [
        'tahun_keluaran', 'warna', 'harga', 'stok', 'terjual', 'tipe_kendaraan', ' mesin', 'tipe_suspensi', 'kapasitas_penumpang', 'tipe_transmisi', 'tipe'
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualann::class, 'nama_kendaraan', 'nama_kendaraan');
    }
}
