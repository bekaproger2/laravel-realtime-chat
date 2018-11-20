<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'receiver'=>$this->getReceiver->name,
            'sender'=>$this->getSender->name,
            'created_at'=>$this->created_at,
            'message'=>json_decode($this->message),
            'chat_room_id'=>$this->chat_room_id
        ];
        
    }
}
