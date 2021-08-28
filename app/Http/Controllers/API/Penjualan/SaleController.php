<?php

namespace App\Http\Controllers\API\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        // return dd($request->all());
        // $validator = Validator::make($request->all(), [

        // ]);

        // //response error validation
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        foreach ($request->invoivejual_id as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $invoicejual_id = $request->invoivejual_id[$i]['uuid'];

            $subtotal = explode(",", $request->subttl);
            $biaya_kirim = explode(",", $request->biaya_kirim);
            $total = explode(",", $request->total);
            Sale::create([
                "uuid" => Str::uuid(),
                "invoicejual_id" => $invoicejual_id,
                "pelanggan_id" => $request->pelanggan_id["uuid"],
                "driver_id" => $request->driver_id["uuid"],
                "tgl_sale" => $request->tgl_sale,
                "jatuh_tempo" => $request->jatuh_tempo,
                "nomor_invoice" => $request->nomor_invoice,
                "faktur_pajak" => $request->faktur_pajak,
                "nomor_po" => $request->nomor_po,
                "nomor_surat_jalan" => $request->nomor_surat_jalan,
                "total" => (preg_replace('/\D/', '', $total[0]) / 1000),
                "diskon" => $request->diskon,
                "ppn" => $request->ppn,
                "subtotal" => (preg_replace('/\D/', '', $subtotal[0]) / 1000),
                "biaya_kirim" => (preg_replace('/\D/', '', $biaya_kirim[0]) / 1000),
            ]);

            InvoiceJual::where('uuid', $invoicejual_id)
                ->update([
                    'status' => 1
                ]);
        }
    }
}
