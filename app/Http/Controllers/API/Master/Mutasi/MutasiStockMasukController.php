<?php

namespace App\Http\Controllers\API\Master\Mutasi;

use App\Http\Controllers\Controller;
use App\Models\Mutasi\Mutasi_stock_masuk;
use Illuminate\Http\Request;

class MutasiStockMasukController extends Controller
{
    public function index()
    {
        // return Barang::get();
        return Mutasi_stock_masuk::select('mutasi_stock_masuk.*', 'barang.nama', 'gudang.gudang')
            ->join('gudang', 'gudang.uuid', '=', 'mutasi_stock_masuk.gudang_id')
            ->join('barang', 'barang.uuid', '=', 'mutasi_stock_masuk.barang_id')
            ->get();
    }
}
