<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
