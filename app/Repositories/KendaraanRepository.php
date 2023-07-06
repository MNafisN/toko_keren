<?php

namespace App\Repositories;

use App\Models\Kendaraan;

class KendaraanRepository
{
    private $kendaraan;

    public function __construct(Kendaraan $kendaraan)
    {
        $this->kendaraan = $kendaraan;
    }

    public function getAll(): Object
    {
        $kendaraans = $this->kendaraan->get();
        return $kendaraans;
        // return Kendaraan::all();
    }

    public function getById(string $id): ?Object
    {
        $kendaraan = $this->kendaraan->find($id);
        return $kendaraan;
        // return Kendaraan::find($did);
    }

    public function getByName(string $nama): ?Object
    {
        $kendaraan = $this->kendaraan->where('nama_kendaraan', $nama)->first();
        return $kendaraan;
    }

    public function store($data): Object
    {
        $kendaraan = new Kendaraan;

        $kendaraan->nama_kendaraan = $data['nama_kendaraan'];
        $kendaraan->tahun_keluaran = $data['tahun_keluaran'];
        $kendaraan->warna = $data['warna'];
        $kendaraan->harga = $data['harga'];
        $kendaraan->stok = $data['stok'];
        $kendaraan->terjual = $data['terjual'];
        $kendaraan->tipe_kendaraan = $data['tipe_kendaraan'];

        if ($data['tipe_kendaraan'] == "motor") {
            $kendaraan->mesin = $data['mesin'];
            $kendaraan->tipe_suspensi = $data['tipe_suspensi'];
            $kendaraan->tipe_transmisi = $data['tipe_transmisi'];
        } else {
            $kendaraan->mesin = $data['mesin'];
            $kendaraan->kapasistas_penumpang = $data['kapasistas_penumpang'];
            $kendaraan->tipe = $data['tipe'];
        }

        $kendaraan->save();

        return $kendaraan->fresh();
    }

    public function update($data, string $id): Object
    {
        $kendaraan = Kendaraan::find($id);
        
        $kendaraan->nama_kendaraan = $data['nama_kendaraan'];
        $kendaraan->tahun_keluaran = $data['tahun_keluaran'];
        $kendaraan->warna = $data['warna'];
        $kendaraan->harga = $data['harga'];
        $kendaraan->stok = $data['stok'];
        $kendaraan->terjual = $data['terjual'];
        $kendaraan->tipe_kendaraan = $data['tipe_kendaraan'];

        if ($data['tipe_kendaraan'] == "motor") {
            $kendaraan->mesin = $data['mesin'];
            $kendaraan->tipe_suspensi = $data['tipe_suspensi'];
            $kendaraan->tipe_transmisi = $data['tipe_transmisi'];
        } else {
            $kendaraan->mesin = $data['mesin'];
            $kendaraan->kapasistas_penumpang = $data['kapasistas_penumpang'];
            $kendaraan->tipe = $data['tipe'];
        }

        $kendaraan->update();

        return $kendaraan->fresh();
    }

    public function updateStok(string $nama, int $jumlah): void
    {
        $kendaraan = $this->getByName($nama);

        $stok = $kendaraan->stok;
        $terjual = $kendaraan->terjual;
        $stok -= $jumlah;
        $terjual += $jumlah;
        $kendaraan->stok = $stok;
        $kendaraan->terjual = $terjual;

        $kendaraan->update();
        // return $kendaraan->fresh();
    }

    public function deleteById(string $id): string
    {
        return $this->kendaraan->destroy($id) ? 'Data Deleted' : 'Data Not Found';
        // return Kendaraan::destroy($data->id) ? 'Data Deleted' : 'Data Not Found';
    }

    public function getAllMobil(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'mobil')->get();
        return $kendaraans;
        // return Kendaraan::where('tipe_kendaraan', 'mobil')->get();
    }

    public function getAllStockMobil(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'mobil')->get();
        return $kendaraans->setHidden(['terjual']);
        // $excludeprice = Kendaraan::where('tipe_kendaraan', 'mobil')->get();
        // return $excludeprice->makeHidden(['terjual']);
    }

    public function getAllTerjualMobil(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'mobil')->get();
        return $kendaraans->setHidden(['stok']);        
        // $excludeprice = Kendaraan::where('tipe_kendaraan', 'mobil')->get();
        // return $excludeprice->makeHidden(['stok']);
    }

    public function getAllMotor(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'motor')->get();
        return $kendaraans;
        // return Kendaraan::where('tipe_kendaraan','motor')->get();
    }

    public function getAllStockMotor(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'motor')->get();
        return $kendaraans->setHidden(['terjual']);
        // $excludeprice = Kendaraan::where('tipe_kendaraan', 'motor')->get();
        // return $excludeprice->makeHidden(['terjual']);
    }

    public function getAllTerjualMotor(): Object
    {
        $kendaraans = $this->kendaraan->where('tipe_kendaraan', 'motor')->get();
        return $kendaraans->setHidden(['stok']);
        // $excludeprice = Kendaraan::where('tipe_kendaraan', 'motor')->get();
        // return $excludeprice->makeHidden(['stok']);
    }
}