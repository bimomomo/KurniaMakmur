<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PelangganController extends Controller
{
    public function index()
    {
        return Pelanggan::get();
    }
    public function store(Request $request)
    {
        foreach ($request["kt"] as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $nama = $request->kt[$i]["nama"];
            $nohp = $request->kt[$i]["nohp"];
            $alamat = $request->kt[$i]["alamat"];
            Pelanggan::create([
                "uuid" => Str::uuid(),
                "nama" => $nama,
                "nohp" => $nohp,
                "alamat" => $alamat,
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        // return dd($request->all());
        foreach ($request["kt"] as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $nama = $request->kt[$i]["nama"];
            $nohp = $request->kt[$i]["nohp"];
            $alamat = $request->kt[$i]["alamat"];
            Pelanggan::where("uuid", $id)->update([
                "nama" => $nama,
                "nohp" => $nohp,
                "alamat" => $alamat,

            ]);
        }
    }
    public function show($id)
    {
        return Pelanggan::where('uuid', $id)->first();
    }
    public function destroy($id)
    {
        Pelanggan::where("uuid", $id)->delete();
    }
    public function deleteall($id)
    {
        $mltId = explode(",", $id);
        Pelanggan::whereIn("uuid", $mltId)->delete();
        // return $dat;
    }
}
