<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
