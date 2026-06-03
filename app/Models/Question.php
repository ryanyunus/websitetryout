<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'tryout_id',
        'question_text',
    ];

    public function tryout()
    {
        return $this->belongsTo(Tryout::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
