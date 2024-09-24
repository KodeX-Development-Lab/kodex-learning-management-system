<?php

namespace App\Http\Middleware;

use App\Modules\Course\Model\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseEnrolledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()) {
            $course = Course::with(['students'])->findOrFail($request->course_id);

            if (in_array(auth()->user(), $course->students->pluck('id')->toArray())) {
                return $next($request);
            }
        }

        return response()->json([
            "status"  => false,
            "message" => "Unauthorized Access",
        ], 403);
    }
}
