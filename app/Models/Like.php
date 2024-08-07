<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'id_berita',
        'id_user'
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
