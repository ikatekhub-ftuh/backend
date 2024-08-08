<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    
    // Menentukan primary key kustom
    protected $primaryKey = 'id_kategori_berita';

    // Menentukan tipe primary key
    protected $keyType = 'int';

    // Primary key bukan auto-increment
    public $incrementing = true;

    protected $fillable = ['kategori'];
}
