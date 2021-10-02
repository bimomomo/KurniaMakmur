<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User\Pengumuman;
use App\Models\Penjualan\Sale;
use App\Models\Penjualan\DataReturn;

class DashboardController extends Controller
{
    public function getDashboardData()
	{
		$data['pengumuman'] = Pengumuman::where('aktif_hingga', '>=', date('Y-m-d'))->get();
		$data['cstmr_beli'] = Sale::selectRaw('count(*) AS jumlah, pelanggan_id')->groupBy('pelanggan_id')->limit(5)->get();
		$data['cstmr_rtrn'] = DataReturn::selectRaw('count(*) AS jumlah, pelanggan_id')->groupBy('pelanggan_id')->limit(5)->get();

		return $data;
	}
}
