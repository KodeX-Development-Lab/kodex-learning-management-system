<?php

namespace App\Modules\CourseUser\Http\Controller\Api;
use App\Http\Controllers\Controller;
use App\Modules\CourseUser\Request\CourseUserRequest;
use App\Modules\CourseUser\Services\CourseUserService;

class CourseUserController extends Controller{

    private $service;

    public function __construct(CourseUserService $service){
        $this->service=$service;
    }

    public function store( $course_id )
    {

        $courseUser = $this->service->store($course_id);

        return response()->json([
            'status'   => true,
            'data'    => [
            'courseUser' => $courseUser,
            ],
            'message' => 'Successfully saved',
        ], 201);
    }
}
