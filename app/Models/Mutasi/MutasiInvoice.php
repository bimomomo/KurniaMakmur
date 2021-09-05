<?php

namespace App\Models\Mutasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasiInvoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'mutasi_invoice';
    protected $fillable = [
        'uuid',
        'invoicejual_id',
        'barang_id',
        'gudang_id',
        'keterangan',
    ];
}
