<?php

namespace App\Http\Controllers\API\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // $data = InvoiceJual::select('invoice_jual.*', 'barang.nama')
        //     ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')->get();;
        // $var = [];
        // foreach ($data as $key => $value) {
        //     $var[$value->uuid] = sale::where('invoicejual_id', $value->uuid)->get();
        // }
        // return $var;
    }

    public function store(Request $request)
    {
        return dd($request->all());
    }
}
