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
            "id"              => $this->id,
            "instructor"      => $this->instructor,
            "title"           => $this->title,
            "slug"            => $this->slug,
            "level"           => $this->level,
            "category"        => $this->category,
            "language"        => $this->language,
            "description"     => $this->description,
            "thumbnail"       => $this->thumbnail,
            "preview"         => $this->preview,
            "total_time"      => $this->total_time,
            "total_time_text" => $this->total_time_text,
            "last_updated_at" => $this->last_updated_at,
            "is_published"    => $this->is_published,
            "created_at"      => $this->created_at,
            "updated_at"      => $this->updated_at,
        ];
    }
}
