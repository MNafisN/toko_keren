<?php

namespace App\Repositories;

use App\Models\Produk;

class ProdukRepository
{
    private $produk;

    public function __construct(Produk $produk)
    {
        $this->produk = $produk;
    }

    public function getAll(): Object
    {
        $produks = $this->produk->get();
        return $produks;
    }

    public function getById(string $produkId): ?Object
    {
        $produk = $this->produk->where('produk_id', $produkId)->first();
        return $produk;
    }

    public function getByCategory(string $category): Object
    {
        $produk = $this->produk->where('produk_kategori', $category)->get();
        return $produk;
    }

    public function getByUser(string $username): Object
    {
        $produk = $this->produk->where('produk_pemasang', $username)->get();
        return $produk;
    }

    public function store(string $produkId, array $data): Object
    {
        $produk = new $this->produk;

        $produk->produk_id = $produkId;
        $produk->produk_kategori = $data['produk_kategori'];
        $produk->produk_judul = $data['produk_judul'];
        $produk->produk_deskripsi = $data['produk_deskripsi'];
        $produk->produk_foto = $data['file'];
        $produk->produk_pemasang = $data['username_pemasang'];
        $produk->display_produk_pemasang = $data['produk_pemasang'];
        $produk->no_telepon = $data['no_telepon'];
        $produk->tampilkan_telepon = $data['tampilkan_telepon'];
        $produk->lokasi_provinsi = $data['lokasi_provinsi'];
        $produk->lokasi_kabupaten_kota = $data['lokasi_kabupaten_kota'];
        $produk->lokasi_kecamatan = $data['lokasi_kecamatan'];
        $produk->lokasi_koordinat = $data['lokasi_koordinat'];
        $produk->date_posted = $data['date_posted'];
        $produk->status = $data['status'];

        $produk->save();
        return $produk->fresh();
    }

    public function update(string $produkId, array $data): Object
    {
        $produk = $this->getById($produkId);

        $produk->produk_kategori = $data['produk_kategori'];
        $produk->produk_judul = $data['produk_judul'];
        $produk->produk_deskripsi = $data['produk_deskripsi'];
        $produk->produk_foto = $data['file'];
        $produk->produk_pemasang = $data['username_pemasang'];
        $produk->display_produk_pemasang = $data['produk_pemasang'];
        $produk->no_telepon = $data['no_telepon'];
        $produk->tampilkan_telepon = $data['tampilkan_telepon'];
        $produk->lokasi_provinsi = $data['lokasi_provinsi'];
        $produk->lokasi_kabupaten_kota = $data['lokasi_kabupaten_kota'];
        $produk->lokasi_kecamatan = $data['lokasi_kecamatan'];
        $produk->lokasi_koordinat = $data['lokasi_koordinat'];
        $produk->date_modified = $data['date_modified'];

        $produk->save();
        return $produk->fresh();
    }

    public function updateProduk(string $produkId, array $data): Object
    {
        $produk = $this->getById($produkId);

        $produk->produk_judul = $data['produk_judul'];
        $produk->produk_deskripsi = $data['produk_deskripsi'];
        $produk->produk_foto = $data['file'];
        $produk->date_modified = $data['date_modified'];

        $produk->save();
        return $produk->fresh();
    }

    public function updateUsername(string $oldUsername, string $newUsername): bool
    {
        $produk = $this->produk->where('produk_pemasang', $oldUsername)->orderBy('created_at', 'asc')->first();
        if (!$produk) { return false; }

        if (count($produk->produk_foto) !== 0) {
            $newPhotos = [];
            foreach ($produk->produk_foto as $key => $value) {
                $newPhotos[$key] = array_replace_recursive($value, [
                    'posted_by' => $newUsername
                ]);
            }
            $produk->produk_foto = $newPhotos;
        }
        $produk->produk_pemasang = $newUsername;
        
        $produk->save();
        return true;
    }

    public function destroy(string $produkId): void
    {
        $produk = $this->getById($produkId);
        $produk->delete();
    }

    public function changeStatus(string $produkId, string $status): void
    {
        $produk = $this->getById($produkId);
        $produk->status = $status;
        $produk->save();
    }
}