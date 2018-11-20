<?php

namespace App\Services;

use App\User;
use App\Project;
use Illuminate\Http\Request;
use App\Notification;
use App\Like;
use Auth;
use App\Events\LikeEvent;

class LikeService {

    public function countLikes(Project $project)
    {
        return $project->likes->count();
    }

    public function like(Project $project, Request $request)
    {
        if($request->isLike)
        {
            $this->deleteLike($project);

            return false;

        }else{
            $this->createLike($project);

            $this->sendNotification($project);

            return true;
        }

        return false;
    }

    public function checkIfLiked(Project $project) : bool
    {
        return (!is_null(Auth::user()->likes()->where('project_id', $project->id)->first()));
    }

    public function createLike(Project $project)
    {
        $like = Like::create([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
        ]);

        return $like;


    }

    public function deleteLike(Project $project)
    {
        $like = $project->likes()->where('user_id', Auth::id());
        $like->delete();
    }

    public function dispatchLikeEvent(Project $project)
    {
        LikeEvent::dispatch(array(
            'follower_id'=>$project->user_id,
            'message'=>Auth::user()->name . ' liked your project'
        ));
    }

    public function sendNotification(Project $project)
    {

        $follower = $project->user->follower;

        $user = Auth::user();

        if($project->user_id != $user->id){
            Notification::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'follower_id' => $follower->id,
                'type' => 'like',
                'message'=>$user->name . ' liked your project',

            ]);

            $this->dispatchLikeEvent($project);
        }
    }
}