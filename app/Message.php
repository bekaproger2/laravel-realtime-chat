<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender', 'receiver', 'chat_room_id', 'message','checked'
    ];

    public function getReceiver(){
        return $this->belongsTo('App\User', 'receiver');
    }

    public function getSender(){
        return $this->belongsTo('App\User','sender');
    }

    public function getChatRoom()
    {
        return $this>belongsTo('App\ChatRoom', 'chat_room_id', 'id');
    }



}
