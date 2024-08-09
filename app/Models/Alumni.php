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
        'nim',
        'tgl_lahir',
        'no_telp',
        'jurusan',
        'angkatan',
        'kelamin',
        'agama',
        'validated'
    ];

    // hide name

    protected $hidden = [
        'golongan_darah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}


