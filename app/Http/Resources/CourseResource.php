<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'content' => $this->content,
            'link' => $this->link,
            'excerpt' => $this->excerpt,
            'rating' => $this->rating,
            'image' => url($this->image),
            'category_title' => $this->category->title,
            'is_free' => $this->is_free
        ];
    }
}
