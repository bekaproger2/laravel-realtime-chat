<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\CommentResource;
use App\Project;

class ProjectApiController extends Controller
{
    
    public function show($id){
        

        return new ProjectResource(Project::find($id));
    }


}
