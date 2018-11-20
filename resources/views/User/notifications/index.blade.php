@extends('layouts.app')

@section('content')
    <div class="col-md-12" style="text-align: center;">
                    <div class="list-group">
                        @if(count($notifications) > 0) 
                        @foreach($notifications as $ntf)
                            <div class="list-group-item" style="{{ $ntf->checked ? '' : 'background-color: grey'}}">
                                <h4 class="list-group-item-heading">
                                    @if($ntf->type == 'comment')
                                        <a href="{{route('project.show',$ntf->project_id) . '#' . $ntf->origin_link}}">{{$ntf->message}}</a>
                                    @elseif($ntf->type == 'like')
                                        <a href="{{route('project.show',$ntf->project_id)}}">{{$ntf->message}}</a>
                                    @elseif($ntf->type == 'message')
                                        <a href="{{route('chat.room', $ntf->user_id)}}">{{$ntf->message}}</a>
                                    @endif
                                </h4>
                                {{--<p class="list-group-item-text">--}}
                                    {{--{{ $project->desc }}--}}
                                {{--</p>--}}
                                {{--<a href="{{route('project.show', array('id'=>$project->id))}}">About</a>--}}
                                {{--<img src="/storage/app/public/uploads/projects/{{$project->project_file1}}" width="100" height="100">--}}
                            </div>
                        @endforeach
                        @else
                            <h4 class="">No notifications</h4>
                        @endif
                    </div>
                </div>
@endsection