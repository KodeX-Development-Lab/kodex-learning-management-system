<?php

use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Auth\Http\Controllers\Api\InstructorController;
use App\Modules\Categories\Http\Controllers\Api\CategoryController;
use App\Modules\CourseFaq\Http\Controller\Api\CourseFaqController;
use App\Modules\CourseUser\Http\Controller\Api\CourseUserController;
use App\Modules\Course\Http\Controller\CourseController;
use App\Modules\Languages\Http\Controllers\Api\LanguageController;
use App\Modules\ProfessionalField\Http\Controller\Api\ProfessionalFieldController;
use App\Modules\Roles\Http\Controllers\Api\RoleController;
use App\Modules\User\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes
Route::prefix('/v1/auth')->name('api.auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/user', [AuthController::class, 'getAuthUser'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
});

Route::prefix('/v1')->middleware(['auth:sanctum'])->name('api.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class)->middleware('CheckAdmin');
    Route::resource('professional-fields', ProfessionalFieldController::class);

    Route::post('become-instructor', [InstructorController::class, 'becomeInstructor'])->name('instructors.become');
    Route::get('instructors', [InstructorController::class, 'index'])->name('instructors.index');
    Route::patch('instructors/{id}/status', [InstructorController::class, 'statusUpdate'])->middleware('CheckAdmin');

    /** Course Related Data */
    Route::resource('categories', CategoryController::class);
    Route::resource('languages', LanguageController::class);
    Route::resource('topics', CategoryController::class);
});

/** Instructor Dashboard */
Route::prefix('/v1/instructor-dashboard/')->middleware(['auth:sanctum'])->name('instructor-dashboard.')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('courses/{course_id}/sections', CourseController::class);
    Route::resource('courses/{course_id}/sections/{section_id}/{lessons}', CourseController::class);
    Route::resource('courses/{course_id}/faqs', CourseFaqController::class);
});

/** Leanrer Side */
Route::prefix('/v1')->middleware(['auth:sanctum'])->name('learner-side.')->group(function () {
    /** Course List, Detail, Enroll */
    Route::get('home/courses', CourseFaqController::class);
    Route::get('home/courses/{id}', CourseFaqController::class);
    Route::get('home/courses/{id}', CourseFaqController::class);
    Route::get('home/courses/{id}/content', CourseFaqController::class);
    Route::post('home/courses/{id}/enroll', CourseFaqController::class);

    Route::prefix('my-learning')->group(function () {
        Route::get('', CourseController::class);
        Route::get('courses/{course_id}/lessons/{lesson_id}', CourseFaqController::class);
        Route::post('courses/{course_id}/lessons/{lesson_id}/complete', CourseFaqController::class);
    });
});
