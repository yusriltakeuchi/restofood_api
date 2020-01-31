<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FoodResource extends Resource
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'price' => $this->price,
            'image' => url('/') . $this->image,
            
        ];
    }
}
