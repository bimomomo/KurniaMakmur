<?php

namespace App\Http\Controllers\API\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\DataReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReturnController extends Controller
{
    public function validasi($request)
    {
        return Validator::make($request->all(), [
            'biaya_kirims' => 'required',
            'driver_id' => 'required',
            'diskon' => 'required',
            'faktur_pajak' => 'required',
            'jatuh_tempo' => 'required',
            'nomor_invoice' => 'required',
            'nomor_po' => 'required',
            'nomor_surat_jalan' => 'required',
            'pelanggan_id' => 'required',
            'ppn' => 'required',
            'tgl_sale' => 'required',
            'total' => 'required',
            'uuidSale' => 'required',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DataReturn::select()
            ->join('sale', 'sale.uuid', 'data_returns.uuidSale')
            ->join('invoice_jual', 'invoice_jual.uuid', 'sale.invoicejual_id')
            ->join('barang', 'barang.uuid', 'invoice_jual.barang_id')
            ->join('gudang', 'gudang.uuid', 'invoice_jual.gudang_id')
            ->get();
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
        // foreach ($request->dataLama as $key => $value) {
        //     $count = count($request->dataLama);
        //     for ($i = 0; $i < $count; $i++) {
        //         $value->aaa = $request->dataLama[$i]['jumlah_satuan_dijual'] - $request->dataLama[$i]['jumlah_satuan_dijual_lama'];
        //     }
        // }
        // return $request->all();
        $validator = $this->validasi($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //
        $total = explode(",", $request->total);
        // return (preg_replace('/\D/', '', $total[0]) / 1000);
        DataReturn::create([
            'uuid' => Str::uuid(),
            'biaya_kirim' => $request->biaya_kirims,
            'diskon' => $request->diskon,
            'driver_id' => $request->driver_id['uuid'],
            'faktur_pajak' => $request->faktur_pajak,
            'jatuh_tempo' => $request->jatuh_tempo,
            'nomor_invoice' => $request->nomor_invoice,
            'nomor_po' => $request->nomor_po,
            'nomor_surat_jalan' => $request->nomor_surat_jalan,
            'pelanggan_id' => $request->pelanggan_id['uuid'],
            'ppn' => $request->ppn,
            'tgl_sale' => $request->tgl_sale,
            'uuidSale' => $request->uuidSale,
            'total' => (preg_replace('/\D/', '', $total[0]) / 1000),
        ]);
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
