<?php

namespace App\Repositories;

use App\Models\Kendaraan;

use Illuminate\Support\Arr;

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
    }

    public function getById(string $id): ?Object
    {
        $kendaraan = $this->kendaraan->where('produk_id', $id)->first();
        return $kendaraan;
    }

    public function store(array $data): Object
    {
        $kendaraan = new $this->kendaraan;

        if ($data['tipe_kendaraan'] == "mobil") { $kendaraan->nextMobilId(); }
        else if ($data['tipe_kendaraan'] == "motor") { $kendaraan->nextMotorId(); }

        $kendaraan->merek = $data['merek'];
        $kendaraan->model = $data['model'];
        $kendaraan->tahun_keluaran = $data['tahun_keluaran'];
        $kendaraan->jarak_tempuh = $data['jarak_tempuh'];
        $kendaraan->warna = $data['warna'];
        $kendaraan->tipe_kendaraan = $data['tipe_kendaraan'];
        if ($data['tipe_kendaraan'] == "mobil") { 
            $kendaraan->spek_kendaraan = Arr::only($data, ['kapasitas_mesin', 'kapasitas_penumpang', 'tipe_transmisi', 'tipe_bodi', 'tipe_bahan_bakar', 'tipe_penjual']); 
        } else if ($data['tipe_kendaraan'] == "motor") {
            $kendaraan->spek_kendaraan = Arr::only($data, ['kapasitas_mesin', 'tipe_transmisi', 'tipe_penjual']);
        }
        $kendaraan->harga = $data['harga'];

        $kendaraan->save();
        return $kendaraan->fresh();
    }

    public function update(string $id, array $data): Object
    {
        $kendaraan = $this->getById($id);

        $kendaraan->merek = $data['merek'];
        $kendaraan->model = $data['model'];
        $kendaraan->tahun_keluaran = $data['tahun_keluaran'];
        $kendaraan->jarak_tempuh = $data['jarak_tempuh'];
        $kendaraan->warna = $data['warna'];
        $kendaraan->tipe_kendaraan = $data['tipe_kendaraan'];
        if ($data['tipe_kendaraan'] == "mobil") { 
            $kendaraan->spek_kendaraan = Arr::only($data, ['kapasitas_mesin', 'kapasitas_penumpang', 'tipe_transmisi', 'tipe_bodi', 'tipe_bahan_bakar', 'tipe_penjual']); 
        } else if ($data['tipe_kendaraan'] == "motor") {
            $kendaraan->spek_kendaraan = Arr::only($data, ['kapasitas_mesin', 'tipe_transmisi', 'tipe_penjual']);
        }
        $kendaraan->harga = $data['harga'];

        $kendaraan->save();
        return $kendaraan->fresh();
    }

    // public function updateStok(string $nama, int $jumlah): void
    // {
    //     $kendaraan = $this->getByName($nama);

    //     $stok = $kendaraan->stok;
    //     $terjual = $kendaraan->terjual;
    //     $stok -= $jumlah;
    //     $terjual += $jumlah;
    //     $kendaraan->stok = $stok;
    //     $kendaraan->terjual = $terjual;

    //     $kendaraan->update();
    //     return $kendaraan->fresh();
    // }

    public function destroy(string $id): void
    {
        $kendaraan = $this->getById($id);
        $kendaraan->delete();
    }
}