<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralSetting extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'general_setting';
	protected $fillable = [
		'uuid',
		'logo',
		'nama',
		'nama_pendek',
		'alamat',
		'no_telp',
		'tag_line',
		'signature',
		'active',
	];
}
