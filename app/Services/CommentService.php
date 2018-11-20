<?php

namespace App\Services;

use App\Comment;
use App\Project;
use Illuminate\Http\Request;
use App\Notification;
use App\Follower;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Events\CommentEvent;
use App\Http\Resources\CommentResource;

class CommentService {

    public function __construct()
    {
        $this->followerService = new FollowerService;
    }

    public function storeComment(Project $project, Request $request)
    {
        $user = Auth::user();


        $comment = Comment::create([
            'content' => json_decode($request->input('data')),
            'project_id' => $project->id,
            'user_id' => $user->id,
            
        ]);

        $this->followerService->addProjectFollower($project, $user);

        $this->dispatchCommentEvent($request, $comment, 'creating');
        $this->sendNotification($project, $comment, $request);
        return $comment;
    
    }

    public function getAllActiveUsersId(Request $request) : array
    {
        $dont_send = [Auth::id()];
        if(count($request->input('active_users')) > 0){
            foreach($request->input('active_users') as $dont_send_id){
                $dont_send[] = $dont_send_id;
            }
        }

        return $dont_send;
    }

    public function dispatchCommentEvent(Request $request, Comment $comment, string $type)
    {
        $activeUsers = $request->active_users;
        switch ($type){
            case 'editing' : 
                foreach ($activeUsers as $userId){
                    if($userId == Auth::id()) continue;
                        CommentEvent::dispatch(array(
                            'comment'=> $request->input('data'),
                            'user_id' => $userId,
                            'type'=>'editing',
                            'index' => $request->index
                        ));
                    }
                    break;
            case 'deleting' :
                foreach ($activeUsers as $userId){
                    if($userId == Auth::id()) continue;
                    CommentEvent::dispatch(array(
                        'user_id' => $userId,
                        'type'=>'deleting',
                        'index' => $request->index
                    ));
                }
                break;
            case 'creating' :
                foreach ($activeUsers as $userId){
                    if($userId == Auth::id()) continue;
                    CommentEvent::dispatch(array(
                        'comment'=> new CommentResource($comment),
                        'user_id' => $userId,
                        'type'=>'creating'
                    ));
                }
                break;
        }
    }

    public function sendNotification(Project $project,Comment $comment, Request $request)
    {

        $user = Auth::user();

        $dontSendUsers = $this->getAllActiveUsersId($request);
        if(!(in_array($project->user_id, $dontSendUsers))){
            $this->sendNotificationToCreator($project, $comment);
            $dontSendUsers[] = $project->user_id;
        }

        $followers = $project->followers()->whereNotIn('user_id', $dontSendUsers)->get();
        
        foreach($followers as $follower){

            Notification::create([
                'message'=>$user->name . ' commented' . $project->name . ' project',
                'type'=>'comment',
                'follower_id'=>$follower->id,
                'project_id'=>$project->id,
                'origin_link'=>$comment->id

            ]);
       }
       

    }

    public function sendNotificationToCreator(Project $project,Comment $comment)
    {

        $user = Auth::user();

        Notification::create([
            'message'=>$user->name . ' commented your project ' . $project->name,
            'type'=>'comment',
            'follower_id'=>$project->user->follower->id,
            'project_id'=>$project->id,
            'origin_link'=>$comment->id
        ]);
    }

}