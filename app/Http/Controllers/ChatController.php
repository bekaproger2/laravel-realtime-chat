<?php

namespace App\Http\Controllers;
use App\ChatRoom;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\Chat;
use App\Notification;
use App\Http\Resources\MessageResource;
use App\Services\ChatService;

class ChatController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->chatService = new ChatService();
        $this->user = Auth::user();
    }

    public function index($receiverId, Request $request){
        if($receiverId !== Auth::id()){
            $receiver = User::findOrFail($receiverId);
            
            $chatRoomId = $this->chatService->getChatRoomId($receiverId, $request);

            return view('privatechat.chatroom', array(
                'user' => Auth::id(),
                'receiver'=>$receiver->id,
                'chatroom'=>$chatRoomId
            ));

        }else{
            return back();
        }

        

    }

    public function  store($receiverId, Request $request){

        $user = Auth::user();

        // $chatRoom = ChatRoom::whereRaw('receiver=? and creator=?',[$receiverId,$user->id])
        //     ->orWhereRaw('creator=? and receiver=?', [$receiverId, $user->id])->first();

        if(is_null($request->chatroom)){
            $chatRoom = $this->chatService->createChatRoom($receiverId, $user->id);
        }else{
            $chatRoom = $this->chatService->findUsersChatRoom(Auth::id(), $receiverId);
        }

        
        
        $message = Message::create([
            'receiver'=>$receiverId,
            'sender'=>Auth::id(),
            'chat_room_id'=>$chatRoom->id,
            'message'=>$request->input('body'),
            'checked'=> $request->input('receiver_online') 
        ]);

        Chat::dispatch([
            'chatroom' => $chatRoom->id,
            'message'=>new MessageResource($message)
        ]);

        return new MessageResource($message);

    }
    public function chatrooms(){
         return view('privatechat.chatroomslist', ['rooms'=>$this->chatService->listRelatedChatRooms()]);
    }
}
