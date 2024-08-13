<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikPendidikan extends Model
{
    use HasFactory;

    protected $table = 'statistik_pendidikan';

    protected $primaryKey   = 'id_statistik_pendidikan';
    protected $keyType      = 'int';
    public $incrementing    = true;

    public $timestamps = false;


    protected $fillable = [
        'jenjang',
        'jumlah',
    ];
}
