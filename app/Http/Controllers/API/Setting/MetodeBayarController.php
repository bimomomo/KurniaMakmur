<?php

namespace App\Http\Controllers\API\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\MetodeBayar;

class MetodeBayarController extends Controller
{
	public function index()
	{
		return MetodeBayar::get();
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama_bank' => 'required|string',
			'nomor_rekening' => 'required',
			'atas_nama' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$usr = MetodeBayar::create([
			"uuid" => Str::uuid(),
			"nama_bank" => $request->nama_bank,
			"nomor_rekening" => $request->nomor_rekening,
			"atas_nama" => $request->atas_nama,
		]);
		return 'Data Sudah Disimpan';
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'nama_bank' => 'required|string',
			'nomor_rekening' => 'required',
			'atas_nama' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		MetodeBayar::where("uuid", $id)->update([
			"nama_bank" => $request->nama_bank,
			"nomor_rekening" => $request->nomor_rekening,
			"atas_nama" => $request->atas_nama,
		]);
		return 'Data Sudah Diubah';
	}
	public function destroy($id)
	{
		MetodeBayar::where("uuid", $id)->delete();
		return 'Data Sudah Dihapus';
	}

	public function deleteall($id)
	{
		// $mltId = explode(",", $id);
		// Satuan::whereIn("uuid", $mltId)->delete();
		// return $dat;
	}
}


