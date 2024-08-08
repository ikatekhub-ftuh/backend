<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use HasFactory;

    protected $table = 'loker';

    protected $primaryKey = 'id_loker';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'konten',
        'perusahaan',
        'tgl_selesai',
        'lokasi',
        'pengalaman_kerja',
        'posisi',
        'role',
    ];
}
