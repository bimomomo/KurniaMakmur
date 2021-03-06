<?php

namespace App\Models\Mutasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mutasi_stock_masuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'mutasi_stock_masuk';
    protected $fillable = [
        'uuid',
        'barang_id',
        'gudang_id',
        'keterangan',
    ];
}
