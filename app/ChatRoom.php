<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'receiver','creator'
    ];

    public function messages()
    {
        return $this->hasMany('App\Message', 'chat_room_id', 'id');
    }


    public function getReceiver (){
        return $this->belongsTo('App\User', 'receiver');
    }

    public function getCreator(){
        return $this->belongsTo('App\User', 'creator');
    }

    public function unreadMessagesNumber($messages)
    {
        return $messages->where('checked',false)->count();
    }

    public function getMessagesByUserId($userId)
    {
        return $this->messages->where('sender', $userId);
    }

}
