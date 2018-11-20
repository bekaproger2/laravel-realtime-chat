<?php

namespace App\Http\Controllers\API;
use App\ChatRoom;
use App\Message;
use App\Http\Resources\MessageResource;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatApiController extends Controller
{
    public function index($roomId, Request $request){

        $chatRoom = ChatRoom::findOrFail($roomId);
        
        return MessageResource::collection($chatRoom->messages);
    }
}
