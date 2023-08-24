<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Exceptions\ArrayException;

class KendaraanService extends ProdukService
{
    protected $KendaraanRepository;

    protected function __construct(KendaraanRepository $KendaraanRepository)
    {
        $this->KendaraanRepository = $KendaraanRepository;
    }

    protected function validatorMobil(array $formData): array
    {
        $formData = parent::validatorProduk($formData, 'mobil');

        $formData['tipe_kendaraan'] = $formData['produk_kategori'];

        $validator = Validator::make($formData, [
            'tipe_kendaraan' => ['required', Rule::in(['mobil'])],
            'merek' => ['required', 'string'],
            'model' => ['required', 'string'],
            'tahun_keluaran' => ['required', 'numeric', 'min:1900', 'max:2023'],
            'jarak_tempuh' => ['required', 'string'],
            'warna' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:100']
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        return ($formData);
    }

    protected function validatorMotor(array $formData): array
    {
        $formData = parent::validatorProduk($formData, 'motor');

        $formData['tipe_kendaraan'] = $formData['produk_kategori'];

        $validator = Validator::make($formData, [
            'tipe_kendaraan' => ['required', Rule::in(['motor'])],
            'merek' => ['required', 'string'],
            'model' => ['required', 'string'],
            'tahun_keluaran' => ['required', 'numeric', 'min:1900', 'max:2023'],
            'jarak_tempuh' => ['required', 'string'],
            'warna' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:100']
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        return ($formData);
    }
}