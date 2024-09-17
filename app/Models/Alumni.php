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
        'nama',
        // 'nim',
        'no_anggota',
        'tgl_lahir',
        'no_telp',
        // 'jurusan',
        // 'angkatan',
        'kelamin',
        'golongan_darah',
        'agama',
        'validated'
    ];

    // hide name

    // protected $hidden = [
    // ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function jenjang_pendidikan()
    {
        return $this->hasMany(JenjangPendidikan::class, 'id_alumni', 'id_alumni');
    }
}
