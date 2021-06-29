<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;
class Comment extends Model
{
    use HasFactory;
    protected $fillable=['text','post_id','user_id'];
    public function post() { // FK relationship
        return $this->belongsTo(Post::class);
    }
     public function user(){
        return $this->belongsTo(User::class);
    } 
}