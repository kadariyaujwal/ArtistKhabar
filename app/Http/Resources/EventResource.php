<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'location'=>$this->location,
            'title'=>$this->title,
            'description'=>$this->description,
            'date'=>$this->date,
            'created_at'=>$this->created_at->diffForHumans(),
            'cover'=>$this->photos->where('cover','1'),
            'images'=>$this->photos->where('cover','0'),

        ];
    }
}
