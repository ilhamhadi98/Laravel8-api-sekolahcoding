<?php

namespace App\Models;

use App\Models\User;
use App\Models\ForumComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Forum extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'title',
        'body',
        'category',
        'slug',
        'user_id'
    ];

    // Relation
    public function user()
    {
        return $this->belongsTo(User::class); //satu forum hanya dimiliki satu user
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class); //satu forum dapat mempunyai banyak comment
    }
}
