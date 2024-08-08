<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'konten',
        'penyelenggara',
        'tgl_event',
        'lokasi_event',
        'kouta',
        'peserta'
    ];
}
