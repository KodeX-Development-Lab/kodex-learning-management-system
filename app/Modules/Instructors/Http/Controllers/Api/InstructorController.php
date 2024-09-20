<?php

namespace App\Modules\Instructors\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Instructors\Enums\InstructorStatus;
use App\Modules\Instructors\Http\Requests\BecomeInstructorRequest;
use App\Modules\Instructors\Models\InstructorDetail;
use App\Modules\Instructors\Services\InstructorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    private $service;

    public function __construct(InstructorService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $instructors = $this->service->all($request);

        return response()->json([
            'status'  => true,
            'data'    => [
                'instructors' => $instructors,
            ],
            'message' => 'Instructors List',
        ], 200);
    }

    public function becomeInstructor(BecomeInstructorRequest $request)
    {
        try {
            $user = auth()->user();

            if ($user->hasRole('Instructor')) {
                return response()->json([
                    'status'  => true,
                    'data'    => null,
                    'message' => 'Already Instructor',
                ], 400);
            }

            $instructor = $this->service->store($request, $user);

            return response()->json([
                'status'  => true,
                'data'    => [
                    'instructor' => $instructor,
                ],
                'message' => 'Instructor create successfully',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    'instructor' => null,
                ],
                'message' => 'Error - ' . $th->getMessage(),
            ], 500);
        }
    }

    public function retryInstructorApplication(BecomeInstructorRequest $request)
    {
        try {
            $user = auth()->user();

            if ($user->hasRole('Instructor')) {
                return response()->json([
                    'status'  => true,
                    'data'    => null,
                    'message' => 'Already Instructor',
                ], 400);
            }

            $instructor = InstructorDetail::where('user_id', $user->id)->first();

            if (!$instructor) {
                $instructor = $this->service->store($request, $user);
            }

            $instructor = $this->service->update($instructor, $request, $user);

            return response()->json([
                'status'  => true,
                'data'    => [
                    'instructor' => $instructor,
                ],
                'message' => 'Instructor create successfully',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    'instructor' => null,
                ],
                'message' => 'Error - ' . $th->getMessage(),
            ], 500);
        }
    }

    public function statusUpdate($id, Request $request)
    {
        $instructor = InstructorDetail::where('id', $id)->first();

        $request->validate([
            'status' => ['required', Rule::in(array_column(InstructorStatus::cases(), 'value'))],
        ]);

        $instructor->update([
            'status'   => $request->status,
            'acted_by' => auth()->user()->id,
            'acted_at' => Carbon::now(),
        ]);

        if ($request->status == 'Approved') {
            $user = User::findOrFail($instructor->user_id);
            $user->assignRole('Instructor');
        }

        return response()->json([
            "status"  => true,
            "data"    => [
                'instructor' => $instructor,
            ],
            "message" => "$instructor->status successfully",
        ], 200);
    }
}
