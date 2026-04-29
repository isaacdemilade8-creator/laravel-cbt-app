<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function Option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected $fillable = ['attempt_id', 'question_id', 'option_id'];
}
