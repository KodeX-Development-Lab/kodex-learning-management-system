<?php

namespace App\Modules\Course\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"         => $this->id,
            "course_id"  => $this->course_id,
            "title"      => $this->title,
            "lessons"    => $this->lessons->map(function ($lesson) {
                return [
                    "id"           => $lesson->id,
                    "section_id"   => $lesson->section_id,
                    "title"        => $lesson->title,
                    "order"        => $lesson->order ?? 0,
                    "is_completed" => in_array(auth()->user()->id, $lesson->completedUsers->pluck('id')->toArray()) ? true : false,
                ];
            }),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
