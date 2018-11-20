<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('chat.{chatroom}', function($user, $chatroom) {

    $room = App\ChatRoom::find($chatroom);
    if($room->creator == $user->id || $room->receiver == $user->id){
        return [$user->name];
    }else{
        return false;
    }
});
 
Broadcast::channel('user.{follower_id}.comment', function($user, $follower_id){
    return true;
});

Broadcast::channel('user.{follower_id}.like', function($user, $follower_id){
    if($user->id == $follower_id){
        return true;
    }else{
        return false;
    }
});


Broadcast::channel('project.{project_id}', function($user, $project_id){
    return $user->id;
});