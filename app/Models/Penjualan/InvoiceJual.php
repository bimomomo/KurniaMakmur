<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceJual extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'invoice_jual';
    protected $fillable = [
        'uuid',
        'barang_id',
        'satuan_id',
        'gudang_id',
        'harga',
        'harga_akhir',
        'total_satuan_jual',
        'jumlah_satuan_dijual',
        'jumlah_satuan_isi',
        'satuan_jual',
        'status',
    ];
}
