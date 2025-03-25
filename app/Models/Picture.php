<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use test\Mockery\Matcher\MatcherDataProviderTrait;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'user_id',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('score');
    }
}
