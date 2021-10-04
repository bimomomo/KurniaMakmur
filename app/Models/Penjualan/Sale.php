<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sale';
    protected $fillable = [
        'uuid',
        'invoicejual_id',
        'pelanggan_id',
        'driver_id',
        'tgl_sale',
        'jatuh_tempo',
        'nomor_invoice',
        'faktur_pajak',
        'nomor_po',
        'nomor_surat_jalan',
        'total',
        'diskon',
        'subtotal',
        'ppn',
        'biaya_kirim',
        'status_bayar',
        'status_pengiriman',
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
