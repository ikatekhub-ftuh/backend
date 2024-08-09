<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori_berita';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $table = 'kategori_berita';

    protected $fillable = ['kategori', 'slug'];

    // hidden
    protected $hidden = ['created_at', 'updated_at'];
}
