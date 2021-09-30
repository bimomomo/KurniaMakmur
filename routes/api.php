<?php

use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\PengumumanController;
use App\Http\Controllers\API\User\HakAksesController;
use App\Http\Controllers\API\Setting\MetodeBayarController;
use App\Http\Controllers\API\Setting\GeneralSettingController;
use App\Http\Controllers\API\Laporan\laporanTransaksiController;
use App\Http\Controllers\API\Master\BarangController;
use App\Http\Controllers\API\Master\BrandController;
use App\Http\Controllers\API\Master\DriverController;
use App\Http\Controllers\API\Master\GudangController;
use App\Http\Controllers\API\Master\KategoriController;
use App\Http\Controllers\API\Master\PelangganController;
use App\Http\Controllers\API\Mutasi\MutasiStockMasukController;
use App\Http\Controllers\API\Master\SatuanController;
use App\Http\Controllers\API\Mutasi\MutasiStockKeluarController;
use App\Http\Controllers\API\Note\myNotesController;
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

Route::middleware('auth:api')->group(function () {
	//User
	Route::apiResources(['user' => UserController::class,]);
	Route::apiResources(['pengumuman' => PengumumanController::class,]);
	Route::apiResources(['hakakses' => HakAksesController::class,]);
	// Setting
	Route::apiResources(['metodebayar' => MetodeBayarController::class,]);
	Route::apiResources(['generalsetting' => GeneralSettingController::class,]);
	Route::post('/generalsettingsetactive/{id}', [GeneralSettingController::class, 'activestatusset']);

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
	Route::post('/deleteInvoice', [InvoiceJualController::class, 'deleteInvoice']);
	
	// Sale Jual
	Route::apiResources(['sale' => SaleController::class,]);
	Route::post('bayar/{id}', [SaleController::class, 'updatebayar']);
	Route::get('detail/{id}', [SaleController::class, 'detailinvoice']);
	Route::get('getAllDataSale', [SaleController::class, 'getAllDataSale']);
	Route::get('test/{id}', [SaleController::class, 'test']);
	Route::get('drivers', [SaleController::class, 'drivers']);

	// updatehormatkami
	Route::put('/updatehormatkami/{id}', [SaleController::class, 'updatehormatkami']);

	// Pelanggan 
	Route::apiResources(['pelanggan' => PelangganController::class,]);
	Route::post('/deletepelanggan/{id}', [PelangganController::class, 'deleteall']);

	// Driver
	Route::apiResources(['driver' => DriverController::class,]);
	Route::post('/deletedriver/{id}', [DriverController::class, 'deleteall']);

	// laporan
	Route::apiResources(['laporan' => laporanTransaksiController::class,]);
	Route::get('/GetlaporanInvoice', [laporanTransaksiController::class, 'GetlaporanInvoice']);
	Route::get('/GetLaporanPengiriman', [laporanTransaksiController::class, 'GetLaporanPengiriman']);
	Route::get('/GetTransaksiPelanggan', [laporanTransaksiController::class, 'GetTransaksiPelanggan']);
	Route::get('GetDetail/{id}', [laporanTransaksiController::class, 'GetDetail']);

	// Note
	Route::apiResources(['notes' => myNotesController::class,]);
	Route::post('/multiDeleteNotes/{id}', [myNotesController::class, 'deletebanyak']);
	
	// Mutasi
	Route::apiResources(['mutasi-keluar' => MutasiStockKeluarController::class,]);
});
