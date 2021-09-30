<?php

namespace App\Http\Controllers\API\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting\GeneralSetting;

class GeneralSettingController extends Controller
{
	public function index()
	{
		return GeneralSetting::get();
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'logo' => 'required|image|max:1024',
			'nama' => 'required',
			'nama_pendek' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'max'=>'Besar file :attribute tidak boleh melebihi :max KB',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$gs = GeneralSetting::create([
			"uuid" => Str::uuid(),
			"nama" => $request->nama,
			"nama_pendek" => $request->nama_pendek,
			"alamat" => $request->alamat,
			"no_telp" => $request->no_telp,
			"tag_line" => $request->tag_line,
			"signature" => $request->signature,
		]);

		$genset = GeneralSetting::where('id', $gs->id)->first();

		$logo = $request->file('logo');
		if ($logo) {
			$names = time().'-'.$logo->extension();
			$logo->move(public_path('images/setting/'.$genset->uuid.'/logo'), $names);
			$logoUrl = 'images/setting/'.$genset->uuid.'/logo/'.$names;
			GeneralSetting::Where('uuid', $genset->uuid)->Update([
				'logo' => $logoUrl,
			]);
		}
		return 'Data Sudah Disimpan';
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'logo' => 'required|image|max:1024',
			'nama' => 'required',
			'nama_pendek' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'max'=>'Besar file :attribute tidak boleh melebihi :max KB',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$logoUrl = null;
		$logo = $request->file('logo');
		if ($logo) {
			$names = time().'-'.$logo->extension();
			$logo->move(public_path('images/setting/'.$id.'/logo'), $names);
			$logoUrl = 'images/setting/'.$id.'/logo/'.$names; 
		}
		GeneralSetting::where("uuid", $id)->update([
			"logo" => $logoUrl,
			"nama" => $request->nama,
			"nama_pendek" => $request->nama_pendek,
			"alamat" => $request->alamat,
			"no_telp" => $request->no_telp,
			"tag_line" => $request->tag_line,
			"signature" => $request->signature,
		]);
		return 'Data Sudah Diubah';
	}
	public function destroy($id)
	{
		GeneralSetting::where("uuid", $id)->delete();
		return 'Data Sudah Dihapus';
	}

	public function activestatusset(Request $request, $id)
	{
		GeneralSetting::whereRaw('1=1')->update(['active'=>0]);
		GeneralSetting::where("uuid", $id)->update(['active'=>1]);
	}
}
