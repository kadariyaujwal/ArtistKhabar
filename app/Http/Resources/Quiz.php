<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Quiz extends JsonResource
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
            'parent_id'=>$this->parent_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'created_at'=>date("F jS, Y", strtotime($this->created_at)),
            'updated_at'=>date("F jS, Y", strtotime($this->updated_at)),
        ];
    }
}
