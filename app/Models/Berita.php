<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'id_kategori',
        'judul',
        'slug',
        'gambar',
        'konten',
        'total_like'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'id_kategori');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_berita');
    }
}
