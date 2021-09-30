<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User\HakAkses;

class HakAksesController extends Controller
{

	public function __construct(Request $request)
	{
		
	}
	public function index(Request $request)
	{
		
		return HakAkses::get();
	}
	public function store(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
			'nama' => 'required|string',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'unique'=>'Isi :attribute ":input" sudah ada',
			'max'=>'Besar file :attribute tidak boleh melebihi :max',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$usr = HakAkses::create([
			"uuid" => Str::uuid(),
			"nama" => $request->nama,
		]);
		return 'Data Sudah Disimpan';
	}
	public function update(Request $request, $id)
	{
		
		$validator = Validator::make($request->all(), [
			'hak_akses' => 'required',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'unique'=>'Isi :attribute ":input" sudah ada',
			'max'=>'Besar file :attribute tidak boleh melebihi :max KB',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		
		HakAkses::where("uuid", $id)->update([
			"hak_akses" => $request->hak_akses,
		]);
		return 'Data Sudah Diupdate';
	}
	public function destroy(Request $request,$id)
	{
		
		$this->checkAccessPermission('user', $request->method());
		HakAkses::where("uuid", $id)->delete();
		return 'Data Sudah Dihapus';
	}
}
