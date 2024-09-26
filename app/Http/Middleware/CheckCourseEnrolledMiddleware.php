<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $already_enrolled = DB::table('enrollments')->where('course_id', $request->course_id)->where('user_id', auth()->user()->id)->first();

            if ($already_enrolled) {
                return $next($request);
            }
        }

        return response()->json([
            "status"  => false,
            "message" => "Unauthorized Access",
        ], 403);
    }
}
