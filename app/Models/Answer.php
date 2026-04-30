<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'option_id'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
