<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sale';
    protected $fillable = [
        'uuid',
        'invoicejual_id',
        'pelanggan_id',
        'tgl_sale',
        'jatuh_tempo',
        'nomor_invoice',
        'faktur_pajak',
        'nomor_po',
        'nomor_surat_jalan',
        'total',
        'diskon',
        'potongan',
        'biaya_kirim',
        'status_bayar',
        'status_pengiriman',
    ];
}
