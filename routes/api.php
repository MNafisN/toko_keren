<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\WilayahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'user'
], function() {
    Route::post('register', [AuthController::class, 'register']);                           // Register user
    Route::post('login', [AuthController::class, 'login']);                                 // Login user
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', [AuthController::class, 'logout']);                           // Logout user
        Route::post('refresh', [AuthController::class, 'refresh']);                         // Refresh user token (180 minutes)
        Route::get('data', [AuthController::class, 'data']);                                // Get user detail
        Route::put('update', [AuthController::class, 'update']);                            // Update user data
        Route::put('update_email', [AuthController::class, 'updateEmail']);                 // Change user email
        Route::put('update_password', [AuthController::class, 'updatePassword']);           // Change user password
        Route::post('upload_photo', [AuthController::class, 'uploadPhoto']);                // Upload user profile picture
        Route::put('delete_photo', [AuthController::class, 'deletePhoto']);                 // Remove user profile picture
    });
});
Route::get('user/download_photo/{username}', [AuthController::class, 'downloadPhoto']);     // Download user profile picture

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::resource('produk', ProdukController::class);
    Route::group([
        'prefix' => 'produk'
    ], function() {
        Route::get('user/me', [ProdukController::class, 'getMyProduk']);                        // List produk by user
        Route::get('detail/{id}', [ProdukController::class, 'getProdukDetail']);                // Get produk detail
        Route::put('status/{id}/{status}', [ProdukController::class, 'setProdukStatus']);       // Update produk status
        Route::post('upload_photo', [ProdukController::class, 'uploadPhoto']);                  // Upload produk photo one by one
        Route::delete('delete_photo/{fileName}', [ProdukController::class, 'deletePhoto']);     // Delete produk photo by name
    });
});
Route::get('produk/download_photo/{fileName}', [ProdukController::class, 'downloadPhoto']);     // Download produk photo by name

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'indonesia'
], function() {
    Route::get('provinsi', [WilayahController::class, 'getAllProvince']);                       // Get all propinsi
    Route::get('kab_kota/{province}', [WilayahController::class, 'getRegencyByProvince']);      // Get kab/kota by propinsi name
    Route::get('kecamatan/{regency}', [WilayahController::class, 'getDistrictByRegency']);      // Get kecamatan by kab/kota name
    Route::get('desa/{district}', [WilayahController::class, 'getVillageByDistrict']);          // Get desa by kecamatan name
});


// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'penjualan'
// ], function () {
//     Route::get('list', [PenjualanController::class, 'getPenjualanHistory']);
//     Route::get('list/{nama}', [PenjualanController::class, 'getPenjualanHistoryKendaraan']);
//     Route::post('buy', [PenjualanController::class, 'beliKendaraan']);
// });