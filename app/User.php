<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');

    }

    public function projects(){
        return $this->hasMany('App\Project', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function messages(){
        return $this->hasMany('App\ChatMessage', 'sender');
    }

    public function chatNotifications (){
        return $this->hasMany('App\Notification', 'user_id');
    }

    public function follower(){
        return $this->hasOne('App\Follower', 'user_id');
    }


}
