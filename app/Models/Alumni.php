<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $primaryKey = 'id_alumni';
    protected $keyType = 'int';
    public $incrementing = true;

    
    protected $fillable = [
        'id_user',
        'nim',
        'nama',
        'tgl_lahir',
        'jurusan',
        'angkatan',
        'kelamin',
        'agama',
        'golongan_darah',
        'validated'
    ];
}


