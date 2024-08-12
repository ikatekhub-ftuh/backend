<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta_event extends Model
{
    use HasFactory;

    protected $table = 'peserta_event';

    protected $primaryKey = 'id_peserta_event';

    protected $fillable = [
        'id_event',
        'id_user',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}
