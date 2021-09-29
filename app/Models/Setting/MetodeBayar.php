<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodeBayar extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = 'metode_bayar';
	protected $fillable = [
		'uuid',
		'nama_bank',
		'nomor_rekening',
		'atas_nama',
	];
}
