<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'duration_minutes',
        'is_active',
        'is_premium',
        'price',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(TryoutAttempt::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
