<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    protected $fillable = ['title', 'duration'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
