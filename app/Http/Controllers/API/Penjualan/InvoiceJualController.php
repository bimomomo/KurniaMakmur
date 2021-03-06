<?php

namespace App\Http\Controllers\API\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Mutasi\MutasiInvoice;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Penjualan\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InvoiceJualController extends Controller
{
    public function index(Request $request)
    {
        // return InvoiceJual::get();
        if ($request->uuid) {
            return InvoiceJual::select('invoice_jual.*', 'barang.nama')
                ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
                ->where('invoice_jual.uuid', $request->uuid)
                ->get();
        }
        return InvoiceJual::select('invoice_jual.*', 'barang.nama')
            ->join('barang', 'barang.uuid', '=', 'invoice_jual.barang_id')
            ->where('invoice_jual.status', 0)
            ->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'required',
            'jumlah_satuan_dijual' => 'required',
            'total_satuan_jual' => 'required',
            'jumlah_satuan_isi' => 'required',
            'harga_akhir' => 'required',
            'satuan_jual' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $harga = explode(",", $request->harga);
        $harga_akhir = explode(",", $request->harga_akhir);
        $satuan_id = $request->produk['satuan_id'];
        $barang_id = $request->produk['uuid'];
        $gudang_id = $request->produk['gudang_id'];
        $terjual = $request->produk['terjual'];
        $sisastock = $request->sisa - $request->total_satuan_jual;
        $stockterjual = $terjual + $request->total_satuan_jual;
        $keterangan = "Invoice Masuk";
        $data = InvoiceJual::create([
            "uuid" => Str::uuid(),
            "satuan_id" => $satuan_id,
            "barang_id" => $barang_id,
            "gudang_id" => $gudang_id,
            "harga" => (preg_replace('/\D/', '', $harga[0]) / 1000),
            "harga_akhir" => (preg_replace('/\D/', '', $harga_akhir[0]) / 1000),
            "total_satuan_jual" => $request->total_satuan_jual,
            "jumlah_satuan_dijual" => $request->jumlah_satuan_dijual,
            "jumlah_satuan_isi" => $request->jumlah_satuan_isi,
            "satuan_jual" => $request->satuan_jual,
        ]);

        if ($data) {
            Barang::where('uuid', $barang_id)->update([
                "terjual" => $stockterjual,
                "sisa" => $sisastock,
            ]);

            MutasiInvoice::create([
                "uuid" => Str::uuid(),
                "invoicejual_id" => $data["uuid"],
                "barang_id" => $barang_id,
                "gudang_id" => $gudang_id,
                "keterangan" => $keterangan,
            ]);
        }
    }
    public function subtotal()
    {
        $datas = InvoiceJual::select('*')
            ->where('status', 0)
            ->get();
        $var = 0;
        foreach ($datas as $key => $value) {
            $var += $value->harga_akhir;
        }
        return $var;
    }
    public function destroy($id)
    {
        $data = InvoiceJual::where("uuid", $id)->get();
        $barang = Barang::where("uuid", $data[0]["barang_id"])->get();
        $stockjual = $data[0]["total_satuan_jual"];
        $sisa = $barang[0]["sisa"];
        $terjual = $barang[0]["terjual"];
        $updatesisa = $sisa + $stockjual;
        $updateterjual = $terjual - $stockjual;
        $date = Carbon::now();
        // return $date->toDateTimeString();

        InvoiceJual::where("uuid", $data[0]["uuid"])->delete();

        Barang::where("uuid", $data[0]["barang_id"])->update([
            "sisa" => $updatesisa,
            "terjual" => $updateterjual
        ]);

        MutasiInvoice::where("invoicejual_id", $data[0]["uuid"])->update([
            "deleted_at" => $date->toDateTimeString(),
            "keterangan" => "Batal Invoice"
        ]);
        // MutasiInvoice::where("uuid", $data[0]["barang_id"])->delete();
        // return $barang;
    }
}
