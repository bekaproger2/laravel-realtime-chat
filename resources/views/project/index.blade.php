
@extends('layouts.app')

@section('content')
    <div class="col-md-12">
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
                                {{--<img src="/storage/app/public/uploads/projects/{{$project->project_file1}}" width="100" height="100">--}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection