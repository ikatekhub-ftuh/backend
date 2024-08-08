<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'alumni';
    
    protected $fillable = [
        'nama',
        'tgl_lahir',
        'stambuk',
        'jurusan',
        'angkatan',
        'kelamin',
        'golongan_darah',
    ];
}


