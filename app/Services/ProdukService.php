<?php

namespace App\Services;

use App\Repositories\ProdukRepository;
use App\Repositories\KendaraanRepository;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use MongoDB\Exception\InvalidArgumentException;
use App\Exceptions\ArrayException;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ProdukService
{
    protected $produkRepository;
    protected $kendaraanRepository;

    public function __construct(ProdukRepository $produkRepository, KendaraanRepository $kendaraanRepository)
    {
        $this->produkRepository = $produkRepository;
        $this->kendaraanRepository = $kendaraanRepository;
    }

    // protected function mergeModelQuery(Object $object1, Object $object2): array
    // {
    //     $array1 = array_diff_key($object1->toArray(), array_flip(['created_at', 'updated_at']));
    //     $array2 = array_diff_key($object2->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));
    //     return array_merge($array1, $array2);
    // }

    protected function validatorProduk(array $formData, string $kategori): array
    {
        $validator = Validator::make($formData, [
            'produk_judul' => ['required', 'string', 'min:4', 'max:50'],
            'produk_deskripsi' => ['required', 'string', 'min:4', 'max:500'],
            'produk_foto.*' => ['required'],
            'produk_kategori' => ['required', Rule::in(['mobil', 'motor'])],
            'lokasi_provinsi' => ['required', 'string'],
            'lokasi_kabupaten_kota' => ['required', 'string'],
            'lokasi_kecamatan' => ['required', 'string'],
            'produk_pemasang' => ['required', 'string'],
            'no_telepon' => ['required', 'string'],
            'tampilkan_telepon' => ['required', 'boolean']
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $formData['lokasi_koordinat'] = [];
        $formData['date_posted'] = (string)Carbon::now('+7:00');
        foreach ($formData['produk_foto'] as $key => $file) {
            // $formData['attachment'][$key] = $document[$key];
            $formData['file'][$key] = $formData['produk_foto'][$key];
            $formData['file'][$key]['file_category'] = 'produk';
            $formData['file'][$key]['posted_by'] = auth()->user()['username'];
            $formData['file'][$key]['created_at'] = (string)Carbon::now('+7:00');
        }

        return $formData;
    }

    public function getAllKendaraan(): array
    {
        $result = [];
        
        $motors = $this->produkRepository->getByCategory('motor');
        $mobils = $this->produkRepository->getByCategory('mobil');

        if ($motors->isEmpty() && $mobils->isEmpty()) {
            throw new InvalidArgumentException('Data produk kendaraan pada database kosong');
        } else {
            $produks = $motors->merge($mobils);
            foreach ($produks as $key => $value) {
                $produk = Arr::except($value->toArray(), ['created_at', 'updated_at']);
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'tahun_keluaran']);
            }
        }

        return $result;
    }

    public function getByCategory(string $category): array
    {
        $result = [];

        $produks = $this->produkRepository->getByCategory($category);
        if ($produks->isEmpty()) {
            throw new InvalidArgumentException("Data produk kategori " . $category . " pada database kosong");
        } else {
            foreach ($produks as $key => $value) {
                $produk = Arr::except($value->toArray(), ['created_at', 'updated_at']);
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'tahun_keluaran']);
            }
        }

        return $result;
    }

    public function store(array $formData): array
    {
        // dd($formData);
        $kendaraan = $this->kendaraanRepository->store($formData);
        $produk = $this->produkRepository->store($kendaraan->produk_id, $formData);

        $produk = array_diff_key($produk->toArray(), array_flip(['created_at', 'updated_at']));
        $detail = array_diff_key($kendaraan->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));

        return array_merge($produk, $detail);
    }

    public function update(array $formData, string $produkId): array
    {
        $produk = $this->produkRepository->getById($produkId);
        if (!$produk) {
            throw new InvalidArgumentException("Data produk tidak ditemukan");
        } 
        
        $formData['date_modified'] = (string)Carbon::now('+7:00');
        $kendaraan = $this->kendaraanRepository->update($produkId, $formData);
        $produk = $this->produkRepository->update($produkId, $formData);

        $produk = array_diff_key($produk->toArray(), array_flip(['created_at', 'updated_at']));
        $detail = array_diff_key($kendaraan->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));

        return array_merge($produk, $detail);
    }

    public function destroy(string $category, string $produkId): string
    {
        $produk = $this->produkRepository->getById($produkId);
        if (!$produk) {
            throw new InvalidArgumentException("Data produk tidak ditemukan");
        } else if ($category == "mobil" || $category == "motor") {
            $name = $produk->produk_judul;
            $this->kendaraanRepository->destroy($produkId);
            $this->produkRepository->destroy($produkId);
        }

        $message = "Produk " . $name . " telah dihapus";
        return $message;
    }

    public function getMyProduk(): array
    {
        $result = [];

        $produks = $this->produkRepository->getByUser(auth()->user()['username']);
        if ($produks->isEmpty()) {
            throw new InvalidArgumentException("Data produk dari " . auth()->user()['username'] . " kosong");
        } else {
            foreach ($produks as $key => $value) {
                $produk = Arr::except($value->toArray(), ['created_at', 'updated_at']);
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'tahun_keluaran']);
            }
        }

        return $result;
    }

    public function getProdukDetail(string $produkId): array
    {
        $result = [];

        $produks = $this->produkRepository->getById($produkId);
        if (!$produks) {
            throw new InvalidArgumentException("Data produk tidak ditemukan");
        } else {
            $produk = array_diff_key($produks->toArray(), array_flip(['created_at', 'updated_at']));
            $detail = array_diff_key($produks->kendaraan->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));
            $result = array_merge($produk, $detail);
        }

        return $result;
    }

    public function changeStatus(string $produkId, string $status): string
    {
        $produk = $this->produkRepository->getById($produkId);
        if (!$produk) {
            throw new InvalidArgumentException("Data produk tidak ditemukan");
        } else {
            $this->produkRepository->changeStatus($produkId, $status);
        }

        return $produk->produk_judul;
    }
}