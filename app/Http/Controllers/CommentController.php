<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Project;
use Illuminate\Http\Request;
use App\Notification;
use App\Follower;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Events\CommentEvent;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;


class CommentController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->commentService  = new CommentService;
    }
    
    public function store(Request $request, Project $project)
    {    

        $comment = $this->commentService->storeComment($project, $request);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Comment $comment, Request $request)
    {
        $this->commentService->dispatchCommentEvent($request, $comment, 'editing');

        return response()->json(['comment'=>$request->input('data'), 'index'=>$request->index]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,Comment $comment, Request $request)
    {
        
        $this->commentService->dispatchCommentEvent($request, $comment, 'deleting');
        
        $comment->delete();
    }
}
