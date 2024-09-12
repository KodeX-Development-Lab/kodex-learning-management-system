<?php

namespace App\Modules\CourseUser\Services;
use App\Modules\CourseUser\Models\CourseUser;
use Illuminate\Support\Facades\Auth;
use App\Modules\CourseUser\Http\Controller\Api\CourseUserController;

class CourseUserService {

    public function store($request,$course_id){
        $courseUser=  CourseUser::create([
            'course_id'=>$course_id,
            'user_id'=>Auth::user()->id,
            'enrolled_at'=>now(),
            'completed_at'=>null
          ]);
          return $courseUser;
      }
}
