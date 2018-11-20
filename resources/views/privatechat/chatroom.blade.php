@extends('layouts.app')

@section('content')
    <chat :receiver = "{{$receiver}}"  :chat-room = "{{$chatroom}}" ></chat>
@endsection