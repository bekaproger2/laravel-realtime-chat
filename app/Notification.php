<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable =[
         'message', 'user_id', 'type', 'checked','follower_id','project_id','origin_link'
    ];

    public function followers(){
        return $this->belongsTo('App\Follower','follower_id');
    }

    public function messageNotificationReceiver(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getFollowersLikesNtfs($followerId)
    {
        return $this->whereRaw('follower_id = ? and type = ?', [$followerId, 'like'])->get();
    }

    public function getFollowerCommentNtfs($followerId)
    {
        return $this->whereRaw('follower_id = ? and type = ?', [$followerId, 'like'])->get();
    }
}
