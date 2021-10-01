<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    public function index()
    {
        return Driver::get();
    }
    public function store(Request $request)
    {
        foreach ($request["kt"] as $key => $value) {
            $data[$key] = $value;
        }
        for ($i = 0; $i < count($data); $i++) {
            $driver = $request->kt[$i]["driver"];
            $no_hp = $request->kt[$i]["no_hp"];
            $alamat_driver = $request->kt[$i]["alamat_driver"];
            $jabatan = $request->kt[$i]["jabatan"];
            Driver::create([
                "uuid" => Str::uuid(),
                "driver" => $driver,
                "no_hp" => $no_hp,
                "alamat_driver" => $alamat_driver,
                "jabatan" => $jabatan,
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
            $driver = $request->kt[$i]["driver"];
            $no_hp = $request->kt[$i]["no_hp"];
            $alamat_driver = $request->kt[$i]["alamat_driver"];
            $jabatan = $request->kt[$i]["jabatan"];
            Driver::where("uuid", $id)->update([
                "driver" => $driver,
                "no_hp" => $no_hp,
                "alamat_driver" => $alamat_driver,
                "jabatan" => $jabatan,
            ]);
        }
    }
    public function show($id)
    {
        return Driver::where('uuid', $id)->first();
    }
    public function destroy($id)
    {
        Driver::where("uuid", $id)->delete();
    }
    public function deleteall($id)
    {
        $mltId = explode(",", $id);
        Driver::whereIn("uuid", $mltId)->delete();
        // return $dat;
    }
}
