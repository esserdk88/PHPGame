<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use hasFactory;

    protected $fillable = [
        'question',
        'category',
        'difficulty',
        'type',
        'correct_answer',
        'incorrect_answers'
    ];

    protected $casts = [
        'incorrect_answers' => 'array'
    ];

    public function responses()
    {
        return $this->hasMany(UserResponse::class);
    }
}
