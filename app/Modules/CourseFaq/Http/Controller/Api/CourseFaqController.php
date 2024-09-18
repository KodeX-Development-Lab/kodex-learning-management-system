<?php

namespace App\Modules\CourseFaq\Http\Controller\Api;
use App\Http\Controllers\Controller;
use App\Modules\CourseFaq\Request\CourseFaqRequest;
use App\Modules\CourseFaq\Services\CourseFaqService;
use App\Modules\Models\CourseFaq;
use Illuminate\Http\Request;

class CourseFaqController extends Controller{
    private $service;

    public function __construct(CourseFaqService $service){
        $this->service=$service;
    }

    public function index(Request $request){
        return response()->json([
            'status'=>true,
            'data'=>[
                'courseFaq'=>$this->service->all($request),
            ],
            'message'=>'success'
        ],200);
    }

    public function show(CourseFaq $courseFaq){
        return response()->json([
            'status'=>true,
            'data'=>$courseFaq,
            'message'=>'Success'
        ],201);
    }

    public function store(CourseFaqRequest $request,$course_id){
        $courseFaq=$this->service->store($request,$course_id);
        return response()->json([
            'status'=>true,
            'data'=>$courseFaq,
            'message'=>'Successfully saved'
        ]);
    }
 public function update(CourseFaqRequest $request,CourseFaq $courseFaq, $course_id){
    $courseFaq=$this->service->update($courseFaq,$request,$course_id);

    return response()->json([
        'status'   => true,
        'data'    => [
            'category' => $courseFaq,
        ],
        'message' => 'Successfully updated',
    ], 200);
 }
    public function destroy(CourseFaq $courseFaq){
       $courseFaq->delete();

       return response()->json([],204);
    }
}
