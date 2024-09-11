<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'star_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'user'=>new UserResource($this->whenLoaded('user')), // 'user' means in Event model function name user
            'attendees'=>AttendeeRource::collection(
                $this->whenLoaded('attendees') // 'attendees' means in Event model function name attendees
            )
        ];
    }
}
