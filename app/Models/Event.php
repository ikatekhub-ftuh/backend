<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $primaryKey = 'id_event';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'konten',
        'penyelenggara',
        'tgl_event',
        'lokasi_event',
        'kuota',
        'peserta'
    ];

    // peserta_event
    public function peserta_event()
    {
        return $this->hasMany(peserta_event::class, 'id_event', 'id_event');
    }
}
