<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    public function index()
    {
        return Satuan::get();
    }
    public function store(Request $request)
    {
        foreach ($request["kt"] as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $satuan_isi = $request->kt[$i]["satuan_isi"];
            $satuan_jual = $request->kt[$i]["satuan_jual"];
            Satuan::create([
                "uuid" => Str::uuid(),
                "satuan_isi" => $satuan_isi,
                "satuan_jual" => $satuan_jual,
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
            $satuan_isi = $request->kt[$i]["satuan_isi"];
            $satuan_jual = $request->kt[$i]["satuan_jual"];
            Satuan::where("uuid", $id)->update([
                "satuan_isi" => $satuan_isi,
                "satuan_jual" => $satuan_jual,
            ]);
        }
    }
    public function destroy($id)
    {
        Satuan::where("uuid", $id)->delete();
    }
    public function deleteall($id)
    {
        $mltId = explode(",", $id);
        Satuan::whereIn("uuid", $mltId)->delete();
        // return $dat;
    }
}
