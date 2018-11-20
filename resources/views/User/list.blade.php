@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-body">
                    <div class="list-group">
                    @if(is_null($users) || $users->count() == 0 )

                    <h4>0 users registered<h4>
                    @else
                        @foreach($users as $user)
                            <div class="list-group-item">
                                <h4 class="list-group-item-heading">
                                    {{ $user->name }}
                                </h4>
                                <p class="list-group-item-text">
                                    {{ $user->email }}
                                </p>
                                <a href="{{route('user.visit', array('id'=>$user->id))}}">Visit</a>
                            </div>
                        @endforeach
                    @endif    
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection