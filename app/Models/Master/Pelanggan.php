<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pelanggan';
    protected $fillable = [
        'uuid',
        'nama',
        'alamat',
        'nohp',
    ];
}
