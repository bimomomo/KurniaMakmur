<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
	public function index()
	{
		return User::get();
	}
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email',
			'password' => 'required',
			'avatar' => 'nullable|image|max:1024',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'unique'=>'Isi :attribute ":input" sudah ada',
			'max'=>'Besar file :attribute tidak boleh melebihi :max',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$usr = User::create([
			"uuid" => Str::uuid(),
			"name" => $request->name,
			"email" => $request->email,
			"password" => Hash::make($request->password),
		]);

		$inputedUser = User::where('id', $usr->id)->first();

		$avatar = $request->file('avatar');
		if ($avatar) {
			$names = time().'-'.$avatar->extension();
			$avatar->move(public_path('images/user/'.$inputedUser->uuid.'/avatar'), $names);
			$avatarUrl = 'images/user/'.$inputedUser->uuid.'/avatar/'.$names;
			User::Where('uuid', $inputedUser->uuid)->Update([
				'avatar' => $avatarUrl,
			]);
		}
		return 'Data Sudah Disimpan';
	}
	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email',
			'avatar' => 'nullable|image|max:1024',
		],[
			'required'=>'Kolom :attribute harus diisi',
			'unique'=>'Isi :attribute ":input" sudah ada',
			'max'=>'Besar file :attribute tidak boleh melebihi :max KB',
		]);

		//response error validation
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$tobeUpdated = [
			"name" => $request->name,
			"email" => $request->email,
		];

		if($request->password){
			$tobeUpdated['password'] = Hash::make($request->password);
		}

		$avatar = $request->file('avatar');
		if ($avatar) {
			$names = time().'-'.$avatar->extension();
			$avatar->move(public_path('images/user/'.$id.'/avatar'), $names);
			$tobeUpdated['avatar'] = 'images/user/'.$id.'/avatar/'.$names; 
		}

		User::where("uuid", $id)->update($tobeUpdated);
		return 'Data Sudah Diubah';
	}
	public function destroy($id)
	{
		User::where("uuid", $id)->delete();
		return 'Data Sudah Dihapus';
	}
	public function deleteall($id)
	{
		// $mltId = explode(",", $id);
		// Satuan::whereIn("uuid", $mltId)->delete();
		// return $dat;
	}
}
