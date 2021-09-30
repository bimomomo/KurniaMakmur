<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User\Pengumuman;

class PengumumanController extends Controller
{
	public function index()
	{
		return Pengumuman::get();
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'pengumuman' => 'required|string',
			'aktif_hingga' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$usr = Pengumuman::create([
			"uuid" => Str::uuid(),
			"pengumuman" => $request->pengumuman,
			"aktif_hingga" => $request->aktif_hingga,
			"type" => $request->type,
		]);
		return 'Data Sudah Disimpan';
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'pengumuman' => 'required|string',
			'aktif_hingga' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		Pengumuman::where("uuid", $id)->update([
			"pengumuman" => $request->pengumuman,
			"aktif_hingga" => $request->aktif_hingga,
			"type" => $request->type,
		]);
		return 'Data Sudah Diubah';
	}
	public function destroy($id)
	{
		Pengumuman::where("uuid", $id)->delete();
		return 'Data Sudah Dihapus';
	}

	public function deleteall($id)
	{
		// $mltId = explode(",", $id);
		// Satuan::whereIn("uuid", $mltId)->delete();
		// return $dat;
	}
}

