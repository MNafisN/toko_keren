<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ArrayException;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Http\JsonResponse;

use Laravolt\Indonesia\Facade as Indonesia;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class WilayahController extends Controller
{
    public function getAllProvince(): JsonResponse
    {
        try {
            $data = Province::all();
            if ($data->isEmpty()) { throw new InvalidArgumentException("Data Propinsi kosong"); }
            $result = [
                'status' => 200,
                'data' => $data
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getRegencyByProvince(string $province): JsonResponse
    {
        try {
            $decoder = rawurldecode($province);
            $propinsi = Province::where('name', 'LIKE', '%'.$decoder.'%')->first();
            if (!$propinsi) { throw new InvalidArgumentException("Propinsi tidak ditemukan"); }
            $data = $propinsi->regencies;
            if ($data->isEmpty()) { throw new InvalidArgumentException("Daftar Kabupaten/Kota kosong"); }
            $result = [
                'status' => 200,
                'data' => $data
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDistrictByRegency(string $regency): JsonResponse
    {
        try {
            $decoder = rawurldecode($regency);
            $kabKota = Regency::where('name', 'LIKE', '%'.$decoder.'%')->first();
            if (!$kabKota) { throw new InvalidArgumentException("Kabupaten/Kota tidak ditemukan"); }
            $data = $kabKota->districts;
            if ($data->isEmpty()) { throw new InvalidArgumentException("Daftar Kecamatan kosong"); }
            $result = [
                'status' => 200,
                'data' => $data
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getVillageByDistrict(string $district): JsonResponse
    {
        try {
            $decoder = rawurldecode($district);
            $kecamatan = District::where('name', 'LIKE', '%'.$decoder.'%')->first();
            if (!$kecamatan) { throw new InvalidArgumentException("Kecamatan tidak ditemukan"); }
            $data = $kecamatan->villages;
            if ($data->isEmpty()) { throw new InvalidArgumentException("Daftar Desa kosong"); }
            $result = [
                'status' => 200,
                'data' => $data
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}