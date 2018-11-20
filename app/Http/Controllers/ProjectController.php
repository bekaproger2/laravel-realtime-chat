<?php

namespace App\Http\Controllers;

use App\Project;
use Dotenv\Validator;
use App\Comment;
use App\Like;
use App\User;
use App\Events\LikeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notification;
use App\Follower;
use App\Services\ProjectService;
use App\Http\Requests\PostProjectRequest;
use App\Services\LikeService;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->projectService = new ProjectService; 
        $this->middleware('auth');
        $this->likeService = new LikeService;
    }

    public function index()
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(PostProjectRequest $request)
    {

        $project = new Project();
        $project->name = $request->name;
        $project->desc = $request->desc;
        $project->email = $request->email;
        $project->user_id = Auth::id();
        $project->project_file = $this->projectService->storeProjectFile($project, $request);
        
        $project->save();

        $this->projectService->createNewFollower($project);     
  
        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show', [
            'project_id'=>$project->id, 
            'user_id' => Auth::id(),
            'isLiked' => $this->likeService->checkIfLiked($project) ? 'true' : 'false' 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit', array('project'=>$project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(PostProjectRequest $request, Project $project)
    {

        $project->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'project_file' => $this->projectService->updateProjectFile($project, $request),
            'email' => $request->email,
        ]);

        return redirect()->route('project.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->projectService->deleteProject($project);
        redirect()->route('project.index'); 
    }

    public function like($id, Request $request){

        $project = Project::find($id);
        
        $this->likeService->like($project, $request);

        return response()->json(['likes' => $this->likeService->countLikes($project)]);
        
    }
}
