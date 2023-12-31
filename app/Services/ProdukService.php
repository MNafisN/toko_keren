<?php

namespace App\Services;

use App\Repositories\ProdukRepository;
use App\Repositories\KendaraanRepository;
use App\Repositories\FileRepository;

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
    protected $fileRepository;

    public function __construct(ProdukRepository $produkRepository, KendaraanRepository $kendaraanRepository, FileRepository $fileRepository)
    {
        $this->produkRepository = $produkRepository;
        $this->kendaraanRepository = $kendaraanRepository;
        $this->fileRepository = $fileRepository;
    }

    // protected function mergeModelQuery(Object $object1, Object $object2): array
    // {
    //     $array1 = array_diff_key($object1->toArray(), array_flip(['created_at', 'updated_at']));
    //     $array2 = array_diff_key($object2->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));
    //     return array_merge($array1, $array2);
    // }

    private function recursive_change_key(array $arr, array $set): array
    {
        if (is_array($arr) && is_array($set)) {
    		$newArr = array();
    		foreach ($arr as $k => $v) {
    		    $key = array_key_exists($k, $set) ? $set[$k] : $k;
    		    $newArr[$key] = is_array($v) ? $this->recursive_change_key($v, $set) : $v;
    		}
    		return $newArr;
    	}
    	return $arr;    
    }

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
            'produk_pemasang' => ['required', 'string', 'max: 20'],
            'no_telepon' => ['required', 'string'],
            'tampilkan_telepon' => ['required', 'boolean']
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $formData['username_pemasang'] = auth()->user()['username'];
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

    protected function validatorProdukUpdate(array $formData): array
    {
        $validator = Validator::make($formData, [
            'produk_judul' => ['required', 'string', 'min:4', 'max:50'],
            'produk_deskripsi' => ['required', 'string', 'min:4', 'max:500'],
            'produk_foto.*' => ['required'],
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

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
                $date = Carbon::parse($produk['date_posted']);
                $produk['jarak_waktu'] = $date->diffForHumans(Carbon::now('+7:00'));
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'display_produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'date_posted', 'jarak_waktu', 'tahun_keluaran', 'harga']);
            }
        }

        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
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
                $date = Carbon::parse($produk['date_posted']);
                $produk['jarak_waktu'] = $date->diffForHumans(Carbon::now('+7:00'));
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'display_produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'date_posted', 'jarak_waktu', 'tahun_keluaran', 'harga']);
            }
        }

        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
        return $result;
    }

    public function store(array $formData): array
    {
        // dd($formData);
        $kendaraan = $this->kendaraanRepository->store($formData);
        $produk = $this->produkRepository->store($kendaraan->produk_id, $formData);

        $produk = array_diff_key($produk->toArray(), array_flip(['created_at', 'updated_at']));
        $detail = array_diff_key($kendaraan->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));

        $result = array_merge($produk, $detail);
        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
        return $result;
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

        $result = array_merge($produk, $detail);
        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
        return $result;
    }

    public function updateProduk(array $formData, string $produkId): array
    {
        $produk = $this->produkRepository->getById($produkId);
        if (!$produk) {
            throw new InvalidArgumentException("Data produk tidak ditemukan");
        } 
        
        $formData['date_modified'] = (string)Carbon::now('+7:00');
        $kendaraan = $this->kendaraanRepository->updateKendaraan($produkId, $formData);
        $produk = $this->produkRepository->updateProduk($produkId, $formData);

        $produk = array_diff_key($produk->toArray(), array_flip(['created_at', 'updated_at']));
        $detail = array_diff_key($kendaraan->toArray(), array_flip(['_id', 'produk_id', 'created_at', 'updated_at']));

        $result = array_merge($produk, $detail);
        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
        return $result;
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
                $date = Carbon::parse($produk['date_posted']);
                $produk['jarak_waktu'] = $date->diffForHumans(Carbon::now('+7:00'));
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'display_produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'date_posted', 'jarak_waktu', 'tahun_keluaran', 'harga']);
            }
        }

        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
        return $result;
    }

    public function getProdukByUser(string $username): array
    {
        $result = [];

        $produks = $this->produkRepository->getByUser($username);
        if ($produks->isEmpty()) {
            throw new InvalidArgumentException("Data produk dari " . $username . " kosong");
        } else {
            foreach ($produks as $key => $value) {
                $produk = Arr::except($value->toArray(), ['created_at', 'updated_at']);
                $date = Carbon::parse($produk['date_posted']);
                $produk['jarak_waktu'] = $date->diffForHumans(Carbon::now('+7:00'));
                $detail = Arr::except($value->kendaraan->toArray(), ['_id', 'produk_id', 'created_at', 'updated_at']);
                $result[] = Arr::only(array_merge($produk, $detail), ['produk_id', 'produk_kategori', 'produk_judul', 'produk_foto', 'produk_pemasang', 'display_produk_pemasang', 'lokasi_provinsi', 'lokasi_kabupaten_kota', 'date_posted', 'jarak_waktu', 'tahun_keluaran', 'harga']);
            }
        }

        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
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

        $result = $this->recursive_change_key($result, array('produk_pemasang' => 'username_pemasang'));
        $result = $this->recursive_change_key($result, array('display_produk_pemasang' => 'produk_pemasang'));
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

    public function uploadPhoto(array $data): array
    {
        $validator = Validator::make($data, [
            'photo' => 'required|mimes:jpg,jpeg,png|max:10000',
        ],
        [
            'photo.required' => 'Please upload a file',
            'photo.mimes' => 'Only jpg, jpeg, and png images are allowed',
            'photo.max' => 'Sorry! Maximum allowed size for a file is 10MB',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['file_name'] = date('Y-m-d H-i-s ') . pathinfo($data['photo']->getClientOriginalName(), PATHINFO_FILENAME) .
                            "." . $data['photo']->getClientOriginalExtension();
        $data['file_category'] = 'produk';
        $data['posted_by'] = auth()->user()['username'];
        $data['created_at'] = (string)Carbon::now('+7:00')->format('Y-m-d H-i-s');

        $photo = $this->fileRepository->uploadPhoto($data);
        return $photo->toArray();
    }

    public function downloadPhoto(string $fileName)
    {
        $fileDecoder = rawurldecode($fileName);
        $photo = $this->fileRepository->getPhotoByName($fileDecoder);
        if (!$photo) {
            throw new InvalidArgumentException('File not found');
        }
        $photo = $this->fileRepository->downloadPhoto($fileDecoder);
        return $photo;
    }

    public function deletePhoto(string $fileName): string
    {
        $fileDecoder = rawurldecode($fileName);
        $photo = $this->fileRepository->getPhotoByName($fileDecoder);
        if (!$photo) {
            throw new InvalidArgumentException('File not found');
        }
        if ($photo->posted_by != auth()->user()['username']) {
            throw new InvalidArgumentException("This user cannot delete other user's product photo");
        }
        $photo = $this->fileRepository->deletePhoto($fileDecoder);

        $message = "File " . $photo . " deleted successfully";
        return $message;
    }
}