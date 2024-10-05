<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Course\Http\Requests\CourseFaqRequest;
use App\Modules\Course\Model\CourseFaq;
use App\Modules\Course\Services\CourseFaqService;
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
                'faqs' => $this->service->index($request),
            ],
            'message' => 'success',
        ], 200);
    }

    public function show($course_id, CourseFaq $faq)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Success',
        ], 200);
    }

    public function store($course_id, CourseFaqRequest $request)
    {
        $faq = $this->service->store($request);

        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function update($course_id, CourseFaq $faq, CourseFaqRequest $request)
    {
        $this->service->update($faq, $request);

        return response()->json([
            'status'  => true,
            'data'    => [
                'faq' => $faq,
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function destroy($course_id, CourseFaq $faq)
    {
        $faq->delete();

        return response()->json([], 204);
    }
}
