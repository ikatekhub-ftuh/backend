<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta_event extends Model
{
    use HasFactory;

    protected $table = 'peserta_event';

    // protected $primaryKey = 'id_peserta_event';
    public $incrementing    = false;
	protected $keyType      = 'int';
	protected $primaryKey   = null;
	public $timestamps      = true;

    protected $fillable = [
        'id_event',
        'id_user',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
