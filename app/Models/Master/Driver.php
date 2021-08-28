<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'driver';
    protected $fillable = [
        'uuid',
        'driver',
        'no_hp',
        'alamat_driver',
        'jabatan',
    ];
}
