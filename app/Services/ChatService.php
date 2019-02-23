<?php

namespace App\Services;

use App\ChatRoom;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Message;
use App\Events\Chat;
use App\Http\Resources\MessageResource;


class ChatService 
{

    private $chatRoom;

    private $rooms_list;

    public function __construct()
    {
        $this->chatRoom = new ChatRoom;
    }

    public function getChatRoomId($receiverId, Request $request)
    {
        
            $chatRoom = $this->findUsersChatRoom(Auth::id(), $receiverId);
       
            if(!is_null($chatRoom)){
                return $chatRoom->id;
            }else{
                return "null";
            }       
        
    }

    /**
     * get all chatrooms of the user
     * 
     * @param integer $userId
     * @param integer $receiverId
     */
    public function findUsersChatRoom(int $userId, int $receiverId) 
    {
        $chatRoom = ChatRoom::whereRaw('receiver=? and creator=?',[$receiverId,$userId])
            ->orWhereRaw('creator=? and receiver=?', [$receiverId, $userId])->first();
        
        return $chatRoom;
    }

    /**
     * Creates a chatRoom
     * 
     * @param integer $receiverId
     * @param integer $userId 
     */
    public function createChatRoom(int $receiverId, int $userId)
    {
        $chatRoom = ChatRoom::create([
            'receiver' => $receiverId,
            'creator'=>$userId
        ]);

        return $chatRoom;
    }


    /**
     * Set all messages of visited room into checked
     * 
     * @param App\ChatRoom $chatroom
     * @return void 
     */
    public function updateChatMessages ($chatroom, $receiverId) 
    {
        foreach ($chatRoom->messages as $message){
            if($message->sender == $receiverId){
                $message->update([
                    'checked'=>true
                ]);
            }
        }

        
    }

    /**
     * Get All Related rooms
     * 
     * @return Illuminate\Support\Collection 
     */
    public function getRelatedChatRooms()
    {
        $user = Auth::user();
        $rooms = ChatRoom::whereRaw('receiver=? or creator=?', [$user->id, $user->id])->get();
        
        return $rooms;
    }

    /**
     * Go through all Related room and turn them into convenient format in order to display them in blade.php
     * 
     * @return array
     */
    public function listRelatedChatRooms()
    {
        $rooms = $this->getRelatedChatRooms();
        $rooms_list = [];
        
        foreach($rooms as $room){
            $unread_messages = 0;
            if($room->creator == Auth::id()){
                $unchecked_messages = $room->unreadMessagesNumber($room->getMessagesByUserId($room->receiver));
                $rooms_list[] = [
                    'last_message' => $room->messages->last(),
                    'user' => $room->getReceiver,
                    'new_msgs'=>$unchecked_messages
                ];
            }else{
                $unchecked_messages = $room->unreadMessagesNumber($room->getMessagesByUserId($room->creator));
                $rooms_list[] = [
                    'last_message' => $room->messages->last(),
                    'user' => $room->getCreator,
                    'new_msgs'=>$unchecked_messages
                ];
            }
        }

        return $rooms_list;

    }

}
