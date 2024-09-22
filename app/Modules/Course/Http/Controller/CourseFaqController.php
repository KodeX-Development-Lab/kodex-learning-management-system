<?php

namespace App\Modules\Course\Http\Controller\Api;

use App\Http\Controllers\Controller;
use App\Modules\CourseFaq\Services\CourseFaqService;
use App\Modules\Course\Http\Requests\CourseFaqRequest;
use App\Modules\Course\Models\CourseFaq;
use Illuminate\Http\Request;

class CourseFaqController extends Controller
{
    private $service;

    public function __construct(CourseFaqService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'faqs' => $this->service->all($request),
            ],
            'message' => 'success',
        ], 200);
    }

    public function show(CourseFaq $faq)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Success',
        ], 201);
    }

    public function store(CourseFaqRequest $request, $course_id)
    {
        $faq = $this->service->store($request, $course_id);

        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Successfully saved',
        ]);
    }

    public function update(CourseFaqRequest $request, CourseFaq $courseFaq, $course_id)
    {
        $faq = $this->service->update($courseFaq, $request, $course_id);

        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function destroy(CourseFaq $courseFaq)
    {
        $courseFaq->delete();

        return response()->json([], 204);
    }
}
