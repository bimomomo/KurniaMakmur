<?php

use App\Http\Controllers\API\Master\BarangController;
use App\Http\Controllers\API\Master\BrandController;
use App\Http\Controllers\API\Master\GudangController;
use App\Http\Controllers\API\Master\KategoriController;
use App\Http\Controllers\API\Mutasi\MutasiStockMasukController;
use App\Http\Controllers\API\Master\SatuanController;
use App\Http\Controllers\API\Penjualan\InvoiceJualController;
use App\Http\Controllers\API\Penjualan\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:api')->group(function () {
// });
Route::apiResources(['kategori' => KategoriController::class,]);
Route::post('/deletekategori/{id}', [KategoriController::class, 'deleteall']);

// Brand
Route::apiResources(['brand' => BrandController::class,]);
Route::post('/deletebrand/{id}', [BrandController::class, 'deleteall']);

// Gudang
Route::apiResources(['gudang' => GudangController::class,]);
Route::post('/deletegudang/{id}', [GudangController::class, 'deleteall']);

// Satuan
Route::apiResources(['satuan' => SatuanController::class,]);
Route::post('/deletesatuan/{id}', [SatuanController::class, 'deleteall']);

// Barang
Route::apiResources(['barang' => BarangController::class,]);
Route::post('/deletebarang/{id}', [BarangController::class, 'deleteall']);
Route::put('/updatestock/{id}', [BarangController::class, 'updatestock']);

// Mutasi stock masuk
Route::apiResources(['mutasistockmasuk' => MutasiStockMasukController::class,]);

// Invoice Jual
Route::apiResources(['invoicejual' => InvoiceJualController::class,]);
Route::get('/subtotal', [InvoiceJualController::class, 'subtotal']);

// Sale Jual
Route::apiResources(['sale' => SaleController::class,]);
