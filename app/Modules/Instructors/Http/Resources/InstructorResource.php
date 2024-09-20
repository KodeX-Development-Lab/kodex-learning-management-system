<?php

namespace App\Modules\Instructors\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            "id"                       => $this->id,
            "user"                     => $this->user,
            'professional_field'       => $this->professionalField,
            'work_experience_year'     => $this->work_experience_year,
            'teaching_experience_year' => $this->teaching_experience_year,
            'status'                   => $this->status,
            'approve_option'           => $this->approve_option,
            'reject_option'            => $this->reject_option,
            "certificates"             => $this->certificates,
            "created_at"               => $this->created_at,
            "updated_at"               => $this->updated_at,
        ];
    }
}
