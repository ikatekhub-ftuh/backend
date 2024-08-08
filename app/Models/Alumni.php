<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alumni';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'alumni';
    
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


