<?php

namespace App\Models\Notes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class myNotes extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'uuid',
        'nama_barang',
        'judul',
        'keterangan',
        'tanggal',
    ];
}
