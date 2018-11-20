<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\CommentResource;

class Project extends JsonResource
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
            'user_id'=>$this->user_id,
            'username'=>$this->user->name,
            'name' => $this->name,
            'comments' => CommentResource::collection($this->comments),
            'likes'=> $this->likes->count(),
            'desc'=>$this->desc
        ];
    }
}
