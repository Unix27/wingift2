<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DrawResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image? url($this->image) : '',
            'link' => $this->link,
            'slug' => $this->slug,
            'prize' => $this->prize,
            'end_date' => $this->end_date->format('d.m.Y'),
            'is_free' => $this->is_free
        ];
    }
}
