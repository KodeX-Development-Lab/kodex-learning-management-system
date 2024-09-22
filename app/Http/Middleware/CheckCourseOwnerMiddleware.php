<?php

namespace App\Http\Middleware;

use App\Modules\Course\Model\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()) {
            if (Course::where('id', $request->course_id)->value('user_id') == auth()->user()->id) {
                return $next($request);
            }
        }

        return response()->json([
            "status"  => false,
            "message" => "Unauthorized Access",
        ], 403);
    }
}
