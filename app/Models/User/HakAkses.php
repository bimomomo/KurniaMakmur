<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HakAkses extends Model
{
    use HasFactory, SoftDeletes;
	protected $table = 'hak_akses';
	protected $fillable = [
		'uuid',
		'nama',
		'hak_akses',
	];
}
