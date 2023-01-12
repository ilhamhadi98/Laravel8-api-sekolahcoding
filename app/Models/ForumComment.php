<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumComment extends Model
{
    use HasFactory;

    // fillable
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'username']); //satu forum hanya dimiliki satu user
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class); //satu comment hanya dimiliki di satu forum
    }
}
