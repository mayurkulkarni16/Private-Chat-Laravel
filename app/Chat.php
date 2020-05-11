<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    protected $fillable = ['session_id', 'user_id', 'type', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];

    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
