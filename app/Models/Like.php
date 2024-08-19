<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    // protected $primaryKey = 'id_like';
    // protected $keyType = 'int';
    // public $incrementing = true;

    protected $fillable = [
        'id_berita',
        'id_user'
    ];

    /**
     * Get the berita that owns the Like
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
