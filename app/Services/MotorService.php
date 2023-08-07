<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Exceptions\ArrayException;

class MotorService extends KendaraanService
{
    protected $KendaraanRepository;

    public function __construct(KendaraanRepository $KendaraanRepository)
    {
        $this->KendaraanRepository = $KendaraanRepository;
    }

    public function validator(array $formData): array
    {
        $formData = parent::validatorMotor($formData);

        $validator = Validator::make($formData, [
            'kapasitas_mesin' => ['required', 'string'],
            'tipe_transmisi' => ['required', 'string', Rule::in(['automatic', 'manual'])],
            'tipe_penjual' => ['required', 'string', Rule::in(['individu', 'dealer'])]
        ]);
        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $formData['status'] = 'aktif';

        return $formData;
    }
}