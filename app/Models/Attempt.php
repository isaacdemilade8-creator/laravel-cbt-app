<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    protected $fillable = ['user_id', 'exam_id', 'score', 'started_at', 'cheat_count'];
}
