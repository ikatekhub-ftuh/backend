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
        'total_like',
    ];

    // like
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_berita');
    }
}
