<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class DataReturn extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'uuid',
        'biaya_kirim',
        'diskon',
        'driver_id',
        'faktur_pajak',
        'jatuh_tempo',
        'nomor_invoice',
        'nomor_po',
        'nomor_surat_jalan',
        'pelanggan_id',
        'ppn',
        'tgl_sale',
        'total',
        'uuidSale',
    ];

	protected $appends = ['pelanggan'];
	public function getPelangganAttribute()
	{
		if ($this->attributes['pelanggan_id']) {
			$plg = DB::table('pelanggan')->where('uuid', $this->attributes['pelanggan_id'])->first();
			return $plg->nama;
		}
		return null;
	}
}
