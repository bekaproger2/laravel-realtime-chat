@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="list-group">
    @foreach($rooms as $room)
            <a href="{{route('chat.room', $room['user']->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1" style="font-weight: bolder;">{{$room['user']->name}}</h5>
                    <span class=" badge badge-primary badge-pill" style="line-height: inherit;">{{$room['new_msgs'] ? $room['new_msgs'] : ''}}</span>
                </div>
                @if($room['last_message']->sender == Auth::id())
                    <p class="mb-1">You: {{$room['last_message']->message}} </p>
                @else
                    <p class="mb-1">{{$room['user']->name}}: {{$room['last_message']->message}}</p>
                @endif
                <small class="text-muted">{{$room['last_message']->created_at->format('d F Y')}}</small>

            </a>
    @endforeach
        </div>
    </div>
@endsection