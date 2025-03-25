<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'picture_id',
        'score',
        'comment'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }

}
