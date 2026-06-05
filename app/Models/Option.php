<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
