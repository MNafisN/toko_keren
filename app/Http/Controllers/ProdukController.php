<?php

namespace App\Http\Controllers;

use App\Services\ProdukService;
use App\Services\MobilService;
use App\Services\MotorService;

use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ArrayException;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller
{
    protected $produkService;
    protected $mobilService;
    protected $motorService;

    public function __construct(ProdukService $produkService, MobilService $mobilService, MotorService $motorService)
    {
        // $this->middleware('auth:api');
        $this->produkService = $produkService;
        $this->mobilService = $mobilService;
        $this->motorService = $motorService;
    }

    public function index(): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->produkService->getAllKendaraan()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function show(string $category): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->produkService->getByCategory($category)
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function create(): JsonResponse
    {
        return response()->json();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            if ($data['produk_kategori'] == 'mobil') {
                $validated = $this->mobilService->validator($data);
            } else if ($data['produk_kategori'] == 'motor') {
                $validated = $this->motorService->validator($data);
            } else {
                throw new InvalidArgumentException('Kategori yang tersedia hanya mobil dan motor');
            }
            $result = [
                'status' => 201,
                'message' => 'Produk ditambahkan',
                'data' => $this->produkService->store($validated)
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function edit(string $id): JsonResponse
    {
        return response()->json();
    }

    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json();
    }

    public function destroy(string $id): JsonResponse
    {
        return response()->json();
    }

    public function getMyProduk(): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->produkService->getMyProduk()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getProdukDetail(string $produkId): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->produkService->getProdukDetail($produkId)
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
