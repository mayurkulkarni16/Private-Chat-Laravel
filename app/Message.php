<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $fillable = ['message', 'session_id'];

    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    public function sendMessage($session_id)
    {
        return $this->chats()->create([
                'session_id' => $session_id,
                'user_id' => Auth::id(),
                'type' => 0
        ]);
    }

    public function receiveMessage($session_id, $message_to)
    {
        return $this->chats()->create([
                'session_id' => $session_id,
                'user_id' => $message_to,
                'type' => 1
        ]);
    }
}
