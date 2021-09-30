<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\User\HakAkses;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = Auth::id();

        if (! $request->session()->exists('nonhashtoken')) {
            $nonhashtoken = Str::random(60);
            User::where('id', $id)->update(['api_token' => hash('sha256', $nonhashtoken)]);
            $request->session()->put('nonhashtoken', $nonhashtoken);
        } else {
            $cuwt = User::where('id', $id)->where('api_token', hash('sha256', $request->session()->get('nonhashtoken')))->count();
            if ($cuwt == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return ('tokenexpired');
            }
        }
		$data['api_token'] = $request->session()->get('nonhashtoken');
		$data['hak_akses'] = json_decode((Auth::user()->hak_akses));
        return view('home',$data);
    }
}
