<?php

namespace App\Modules\Course\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseListResource extends JsonResource
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
            "id"                      => $this->id,
            "instructor"              => $this->instructor,
            "title"                   => $this->title,
            "slug"                    => $this->slug,
            "thumbnail"               => $this->thumbnail,
            "lessons_count"           => $this->lessons_count ?? 0,
            "students_count"          => $this->students_count ?? 0,
            "level"                   => $this->level,
            "category"                => $this->category,
            "language"                => $this->language,
            "topics"                  => $this->topics,
            "description"             => $this->description,
            "preview_video_url"       => $this->preview_video_url,
            "total_time_minutes"      => $this->total_time_minutes,
            "total_time_minutes_text" => $this->total_time_minutes_text,
            "last_updated_at"         => $this->last_updated_at,
            "is_published"            => $this->is_published,
            "created_at"              => $this->created_at,
            "updated_at"              => $this->updated_at,
        ];
    }
}
