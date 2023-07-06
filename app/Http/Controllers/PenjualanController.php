<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PenjualanService;
use Exception;

class PenjualanController extends Controller
{
    private $penjualanService;

    public function __construct(PenjualanService $penjualanService)
    {
        $this->penjualanService = $penjualanService;
    }

    public function getPenjualanHistory(): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->penjualanService->getAll()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getPenjualanHistoryKendaraan(string $nama): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->penjualanService->getByNamaKendaraan($nama)
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function beliKendaraan(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $penjualan = $this->penjualanService->beliKendaraan($data);
            return response()->json([
                'status' => 201,
                'message' => 'Penjualan added successfully',
                'data_penjualan' => $penjualan
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }
}
