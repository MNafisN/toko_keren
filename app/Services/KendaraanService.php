<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class KendaraanService
{
    protected $KendaraanRepository;

    public function __construct(KendaraanRepository $KendaraanRepository)
    {
        $this->KendaraanRepository = $KendaraanRepository;
    }

    public function validator($request)
    {
        $validator = Validator::make($request, [
            'nama_kendaraan' => 'required|unique:App\Models\Kendaraan,nama_kendaraan',
            'tahun_keluaran' => 'required|numeric|min:1900|max:2500',
            'warna' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'terjual' => ['required', 'numeric'],
            'tipe_kendaraan' => ['required', Rule::in(['motor', 'mobil'])],
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        return ($request);
    }

    public function getAll()
    {
        return $this->KendaraanRepository->getAll();
    }

    public function findById(string $id)
    {
        return $this->KendaraanRepository->getById($id);
    }

    public function store($data)
    {
        return $this->KendaraanRepository->store($data);
    }

    public function update($data, string $id)
    {
        return $this->KendaraanRepository->update($data, $id);
    }

    public function deleteById(string $id)
    {
        return $this->KendaraanRepository->deleteById($id);
    }

    public function getAllMobil()
    {
        return $this->KendaraanRepository->getAllMobil();
    }

    public function getAllStockMobil()
    {
        return $this->KendaraanRepository->getAllStockMobil();
    }

    public function getAllTerjualMobil()
    {
        return $this->KendaraanRepository->getAllTerjualMobil();
    }

    public function getAllMotor()
    {
        return $this->KendaraanRepository->getAllMotor();
    }

    public function getAllStockMotor()
    {
        return $this->KendaraanRepository->getAllStockMotor();
    }

    public function getAllTerjualMotor()
    {
        return $this->KendaraanRepository->getAllTerjualMotor();
    }
}