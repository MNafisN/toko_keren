<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class MotorService extends KendaraanService
{
    protected $KendaraanRepository;

    public function __construct(KendaraanRepository $KendaraanRepository)
    {
        $this->KendaraanRepository = $KendaraanRepository;
    }

    public function validator($data)
    {
        $data = parent::validator($data->all());

        $validator = Validator::make($data, [
            'mesin' => ['required', 'string'],
            'tipe_suspensi' => ['required', 'string'],
            'tipe_transmisi' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $data;
    }
}