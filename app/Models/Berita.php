<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $primaryKey = 'id_berita';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id_kategori_berita',
        'judul',
        'penulis',
        'slug',
        'gambar',
        'konten',
        'deskripsi',
        'total_like',
    ];

    // like
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_berita');
    }

    // kategori berita
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'id_kategori_berita');
    }
}
