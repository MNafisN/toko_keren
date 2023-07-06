<?php

namespace App\Http\Controllers;

use App\Services\KendaraanService;
use App\Services\MobilService;
use App\Services\MotorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KendaraanController extends Controller
{
    private $motorService;
    private $kendaraanService;
    private $mobilService;

    public function __construct(MotorService $motorService, KendaraanService $kendaraanService, MobilService $mobilService)
    {
        $this->middleware('auth:api');
        $this->motorService = $motorService;
        $this->kendaraanService = $kendaraanService;
        $this->mobilService = $mobilService;
    }

    public function index(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAll());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function show(string $kendaraanId): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->findById($kendaraanId));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            if ($request->tipe_kendaraan == 'motor') {
                $datatervalidasi = $this->motorService->validator($request);
                return response()->json($this->kendaraanService->store($datatervalidasi));
            } else {
                $datatervalidasi = $this->mobilService->validator($request);
                return response()->json($this->kendaraanService->store($datatervalidasi));
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function update(Request $request, string $kendaraanId): JsonResponse
    {
        try {
            $datatervalidasi = $this->motorService->validator($request);
            return response()->json($this->kendaraanService->update($datatervalidasi, $kendaraanId));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function destroy(string $kendaraanId): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->deleteById($kendaraanId));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllMobil(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllMobil());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllStockMobil(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllStockMobil());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllTerjualMobil(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllTerjualMobil());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllMotor(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllMotor());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllStockMotor(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllStockMotor());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getAllTerjualMotor(): JsonResponse
    {
        try {
            return response()->json($this->kendaraanService->getAllTerjualMotor());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
