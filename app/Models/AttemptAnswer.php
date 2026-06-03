<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tryout_attempt_id',
        'question_id',
        'option_id',
    ];

    public function attempt()
    {
        return $this->belongsTo(TryoutAttempt::class, 'tryout_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
