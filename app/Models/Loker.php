<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use HasFactory;

    protected $table = 'loker';

    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'konten',
        'perusahaan',
        'durasi',
        'lokasi_kerja',
        'pengalaman_kerja',
        'posisi',
    ];
}
