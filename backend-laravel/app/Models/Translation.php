<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'text',
        'translated_text',
    ];

    /**
     * Get the user that owns the translation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
