<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Message extends Model
{
    use HasFactory;
    protected $fillable=['text','sender_id','receiver_id'];
    public function sender() { // FK relationship
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver() { // FK relationship
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
