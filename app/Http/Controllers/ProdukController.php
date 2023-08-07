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
                'status' => 404,
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
                'status' => 404,
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
                'status' => 200,
                'message' => 'Produk diperbarui',
                'data' => $this->produkService->update($validated, $id)
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

    public function destroy(string $produkId): JsonResponse
    {
        try {
            if (str_contains($produkId, 'MBL')) {
                $message = $this->produkService->destroy('mobil', $produkId);
            } else if (str_contains($produkId, 'MTR')) {
                $message = $this->produkService->destroy('motor', $produkId);
            } else {
                throw new InvalidArgumentException('Produk ID invalid');
            }
            $result = [
                'status' => 200,
                'message' => $message
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
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
                'status' => 404,
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
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function setProdukStatus(string $id, string $status)
    {
        try {
            $produk = $this->produkService->changeStatus($id, $status);
            $result = [
                'status' => 200,
                'message' => "Status " . $produk . " telah diubah menjadi " . $status
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
