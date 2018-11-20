@extends('layouts.app')

@section('content')
    <div class="content container">
        <h3>{{strtoupper($user->name)}}'s Profile</h3>
        @if(Auth::id() == $user->id)
        <a class="btn btn-primary pull-left " href="{{route('user.edit_form', array('user'=>$user))}}"> Edit profile </a>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-body">
                    <div class="list-group">
                        @foreach($projects as $project)
                            <div class="list-group-item">
                                <h4 class="list-group-item-heading">
                                    {{ $project->name }}
                                </h4>
                                <p class="list-group-item-text">
                                    {{ $project->desc }}
                                </p>
                                <a href="{{route('project.show', array('id'=>$project->id))}}">About</a>
                                <img src="/storage/uploads/projectfiles/{{$project->id . '/' .$project->project_file}}" width="100" height="100">
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @else
            <a class ="btn btn-primary" href="{{route('chat.room', $user->id)}}" >Write to this User</a>
        @endif
    </div>

@endsection