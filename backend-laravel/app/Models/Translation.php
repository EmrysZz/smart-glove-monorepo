<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'translated_text',
        'raw_sensor_data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'raw_sensor_data' => 'array',
        ];
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
