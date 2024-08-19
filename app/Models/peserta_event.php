<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class peserta_event extends Model
{
    use HasFactory;

    protected $table = 'peserta_event';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = true;

    protected $fillable = [
        'id_event',
        'id_user',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}