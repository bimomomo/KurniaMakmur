<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'pengumuman';
	protected $fillable = [
		'uuid',
		'pengumuman',
		'type',
		'tertuju',
		'aktif_hingga',
	];
}
