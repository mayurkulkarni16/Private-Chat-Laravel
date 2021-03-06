<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $fillable = ['user1_id', 'user2_id'];

    public function chats()
    {
        return $this->hasManyThrough('App\Chat', 'App\Message');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
