<?php 

namespace App\Services;

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
use App\Http\Requests\PostProjectRequest;

class ProjectService {


    public function storeProjectFile(Project $project, PostProjectRequest $request)
    {
        $filename = '';

        if($request->hasFile('project_file')){
            $file = $request->file('project_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('/public/uploads/projectfiles/', $file, $filename);
        }

        return $filename;

    }

    public function createNewFollower($project)
    {
        $follower = '';

        if(!Auth::user()->follower()->count() > 0){
            $follower = Follower::create([
                'user_id'=>Auth::id()
            ]);
            $project->followers()->save($follower);
        }else{
            $project->followers()->save(Auth::user()->follower);
        }

        return $follower;
    }

    public function createProject(PostProjectRequest $reqest)
    {        
        $project = new Project();
        $project->name = $request->name;
        $project->desc = $request->desc;
        $project->email = $request->email;
        $project->user_id = Auth::id();
        $project->project_file = $this->storeProjectFile();

        $project->save();

        $this->createNewFollower($project);       

        return redirect()->route('project.show', $project->id);
    }

    public function updateProjectFile(Project $project, PostProjectRequest $request)
    {
        $filename = '';
        if($request->hasFile('project_file')){
            
            if($project->project_file != ''){
                $this->deleteProjectFile($project->project_file);
            }

            $filename =  $this->storeProjectFile($project, $request);
        
        }
        return $filename;
    }

    public function deleteProjectFile(string $project_file)
    {
        Storage::delete('/public/uploads/projectfiles/' . $project_file);
    }

    public function deleteProject(Project $project)
    {
        if($project->project_file != ''){
            $this->deleteProjectFile($project->project_file);
        }

        $project->delete();
    }

}