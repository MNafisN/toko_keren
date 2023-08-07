<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Exceptions\ArrayException;

class MobilService extends KendaraanService
{
    protected $KendaraanRepository;

    public function __construct(KendaraanRepository $KendaraanRepository)
    {
        $this->KendaraanRepository = $KendaraanRepository;
    }

    public function validator(array $formData): array
    {
        $formData = parent::validatorMobil($formData);

        $validator = Validator::make($formData, [
            'kapasitas_mesin' => ['required', 'string'],
            'kapasitas_penumpang' => ['required', 'numeric', 'min:1', 'max:8'],
            'tipe_transmisi' => ['required', 'string', Rule::in(['automatic', 'manual'])],
            'tipe_bodi' => ['required', 'string'],
            'tipe_bahan_bakar' => ['required', 'string', Rule::in(['bensin', 'diesel', 'hybrid', 'listrik'])],
            'tipe_penjual' => ['required', 'string', Rule::in(['individu', 'dealer'])]
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $formData['status'] = 'aktif';

        return $formData;
    }
}