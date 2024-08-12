<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class JenjangPendidikan extends Model
{
    use HasFactory;

    protected $table = 'jenjang_pendidikan';

    protected $primaryKey   = 'id_jenjang_pendidikan';
    protected $keyType      = 'int';
    public $incrementing    = true;

    protected $fillable = [
        'id_alumni',
        'jenjang'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
