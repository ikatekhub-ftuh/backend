<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $primaryKey   = 'id_jurusan';
    protected $keyType      = 'int';
    public $incrementing    = true;

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan'
    ];
}
