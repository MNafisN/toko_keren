<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;

use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\BelongsTo;
use App\Models\Penjualan;
use App\Models\Produk;

class Kendaraan extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'kendaraans';

    protected $fillable = [
        'produk_id',
        'merek',
        'model',
        'tahun_keluaran', 
        'jarak_tempuh',
        'warna',
        'tipe_kendaraan',
        'spek_kendaraan',
        'harga'
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'nama_kendaraan', 'nama_kendaraan');
    }

    public function nextMobilId()
    {
        $idNow = "MBL-";

        $this->produk_id = $idNow . str_pad(self::getID('mobil'), 5, '0', STR_PAD_LEFT);
    }

    public function nextMotorId()
    {
        $idNow = "MTR-";

        $this->produk_id = $idNow . str_pad(self::getID('motor'), 5, '0', STR_PAD_LEFT);
    }

    public static function bootUseAutoIncrementID()
    {
        static::creating(function ($model) {
            $model->sequencial_id = self::getID($model->getTable());
        });
    }

    public function getCasts()
    {
        return $this->casts;
    }
    
    private static function getID(string $type)
    {
        if ($type == 'mobil') {
            $seq = DB::connection('mongodb')->getCollection('produks_count')->findOneAndUpdate(
                ['ref' => 'ref'],
                ['$inc' => ['mobil_seq' => 1]],
                ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
            );
            return $seq->mobil_seq;
        } else if ($type == 'motor') {
            $seq = DB::connection('mongodb')->getCollection('produks_count')->findOneAndUpdate(
                ['ref' => 'ref'],
                ['$inc' => ['motor_seq' => 1]],
                ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
            );
            return $seq->motor_seq;
        }
    }
}
