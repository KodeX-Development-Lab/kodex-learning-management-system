<?php

namespace App\Modules\Course\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailResource extends JsonResource
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
            "id"               => $this->id,
            "is_instructor"    => $this->is_instructor ?? false,
            "already_enrolled" => $this->already_enrolled ?? false,
            "instructor"       => $this->instructor,
            "title"            => $this->title,
            "slug"             => $this->slug,
            "thumbnail"        => $this->thumbnail,
            "level"            => $this->level,
            "category"         => $this->category,
            "language"         => $this->language,
            "what_will_learn"  => $request->what_will_learn,
            "requirements"     => $request->requirements,
            "description"      => $this->description,
            "for_whom"         => $request->for_whom,
            "preview"          => $this->preview,
            "total_time"       => $this->total_time,
            "total_time_text"  => $this->total_time_text,
            "last_updated_at"  => $this->last_updated_at,
            "sections"         => $this->sections,
            "is_published"     => $this->is_published,
            "useful_links"     => $this->useful_links,
            "created_at"       => $this->created_at,
            "updated_at"       => $this->updated_at,
        ];
    }
}
