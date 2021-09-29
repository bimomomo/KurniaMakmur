<?php

namespace App\Http\Controllers\API\Mutasi;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\Sale;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class MutasiStockKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->gudang) {
            $x = Sale::select(
                'sale.*',
                'invoice_jual.*',
                'barang.nama as namaBarang',
                'barang.*',
                'gudang.*',
                'pelanggan.nama as namaPelanggan',
                'pelanggan.*',
            )
                ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
                ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
                ->join('gudang', 'gudang.uuid', 'barang.gudang_id')
                ->join('pelanggan', 'pelanggan.uuid', 'sale.pelanggan_id')
                ->where('sale.status_bayar', 1)
                ->where('gudang.uuid', $request->gudang)
                ->get();
        } else {
            $x = Sale::select(
                'sale.*',
                'invoice_jual.*',
                'barang.nama as namaBarang',
                'barang.*',
                'gudang.*',
                'pelanggan.nama as namaPelanggan',
                'pelanggan.*',
            )
                ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
                ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
                ->join('gudang', 'gudang.uuid', 'barang.gudang_id')
                ->join('pelanggan', 'pelanggan.uuid', 'sale.pelanggan_id')
                ->where('sale.status_bayar', 1)
                // ->where('gudang.uuid',$request->gudang)
                ->get();
        }
        return response()->json(['data' => $x, 'pesan' => 'oke']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
