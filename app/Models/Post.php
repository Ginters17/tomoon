<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;
class Post extends Model
{
    use HasFactory;
    protected $fillable=['text','user_id'];
    public function comment() { // FK relationship
        return $this->hasMany(Comment::class);
    }
    public function user() { // FK relationship
        return $this->belongsTo(User::class);
    }
}