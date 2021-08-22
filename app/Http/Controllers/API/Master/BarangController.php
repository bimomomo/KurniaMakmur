<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Satuan;
use App\Models\Mutasi\Mutasi_stock_masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index()
    {
        // return Barang::get();
        return Barang::select('barang.*', 'gudang.gudang', 'brand.brand', 'kategori.kategori', 'satuan.satuan_isi')
            ->join('gudang', 'gudang.uuid', '=', 'barang.gudang_id')
            ->join('brand', 'brand.uuid', '=', 'barang.brand_id')
            ->join('kategori', 'kategori.uuid', '=', 'barang.kategori_id')
            ->join('satuan', 'satuan.uuid', '=', 'barang.satuan_id')->get();
    }

    public function store(Request $request)
    {
        Barang::create([
            "uuid" => Str::uuid(),
            "kategori_id" => $request->kategori_id,
            "brand_id" => $request->brand_id,
            "gudang_id" => $request->gudang_id,
            "satuan_id" => $request->satuan_id["uuid"],
            "nama" => $request->nama,
            "keterangan" => $request->keterangan,
        ]);
    }
    public function update(Request $request, $id)
    {
        Barang::where("uuid", $id)->update([
            "kategori_id" => $request->kategori_id,
            "brand_id" => $request->brand_id,
            "gudang_id" => $request->gudang_id,
            "satuan_id" => $request->satuan_id[0]["uuid"],
            "nama" => $request->nama,
            "keterangan" => $request->keterangan,
        ]);
    }
    public function destroy($id)
    {
        Barang::where("uuid", $id)->delete();
    }
    public function deleteall($id)
    {
        $mltId = explode(",", $id);
        Barang::whereIn("uuid", $mltId)->delete();
    }
    public function updatestock(Request $request, $id)
    {
        // return dd($request->all());
        $validator = Validator::make($request->all(), [
            'newstock' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newstock = $request->sisa + $request->newstock;
        $stock = $request->sisa +  $request->newstock;
        $keterangan = "Barang Masuk";
        Barang::where("uuid", $id)->update([
            "sisa" => $newstock,
            "terbeli" => $stock
        ]);

        Mutasi_stock_masuk::create([
            "uuid" => Str::uuid(),
            "barang_id" => $request->uuid,
            "gudang_id" => $request->gudang_id[0]["uuid"],
            "keterangan" => $keterangan,
        ]);
    }
}
