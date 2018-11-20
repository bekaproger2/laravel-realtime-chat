<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable =[
        'name', 'desc', 'project_file', 'email', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function followers(){
        return $this->belongsToMany('App\Follower','followers_projects','project_id','follower_id');
    }



}
