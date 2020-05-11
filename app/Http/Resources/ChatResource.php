<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'message' => $this->message['message'],
            'id' => $this->id,
            'type' => $this->type,
            'read_at' => $this->read_at ? $this->read_at->diffForHumans() : '',
            'sent_at' => $this->created_at->diffForHumans()
        ];
    }
}
