<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'barang';
    protected $fillable = [
        'uuid',
        'kategori_id',
        'brand_id',
        'gudang_id',
        'satuan_id',
        'nama',
        'keterangan',
        'sisa',
        'terjual',
        'terbeli',
    ];
}
