
@extends('layouts.app')
@section('css')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/projectpage.css') }}" rel="stylesheet">
@endsection

@section('content')

    <project :project_id="{{$project_id}}"  :user_id="{{$user_id}}"   :liked="{{$isLiked}}"></project>

@endsection