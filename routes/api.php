<?php

use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Categories\Http\Controllers\Api\CategoryController;
use App\Modules\Course\Http\Controller\CourseFaqController;
use App\Modules\Course\Http\Controller\InstructorCourseController;
use App\Modules\Course\Http\Controller\LessonController;
use App\Modules\Course\Http\Controller\SectionController;
use App\Modules\Instructors\Http\Controllers\Api\InstructorController;
use App\Modules\Languages\Http\Controllers\Api\LanguageController;
use App\Modules\LearnerSide\Http\Controllers\Api\LeanerSideHomeController;
use App\Modules\LearnerSide\Http\Controllers\Api\MyLearningController;
use App\Modules\ProfessionalField\Http\Controller\Api\ProfessionalFieldController;
use App\Modules\Roles\Http\Controllers\Api\RoleController;
use App\Modules\Storage\Http\Controllers\Api\FileUploadController;
use App\Modules\Topics\Http\Controller\TopicController;
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

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'getAuthUser'])->middleware('auth:sanctum');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum')->name('changePassword');
    });
});

/** General APIs */
Route::prefix('/v1')->middleware(['auth:sanctum'])->name('api.')->group(function () {
    Route::post('file-uploads', [FileUploadController::class, 'store'])->name('file-uploads');
    Route::post('become-instructor', [InstructorController::class, 'becomeInstructor'])->name('instructors.become');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class)->middleware('CheckAdmin');
        Route::resource('professional-fields', ProfessionalFieldController::class);

        Route::get('instructors', [InstructorController::class, 'index'])->name('instructors.index');
        Route::patch('instructors/{id}/status', [InstructorController::class, 'statusUpdate'])->middleware('CheckAdmin');

        /** Course Related Data */
        Route::resource('categories', CategoryController::class);
        Route::resource('languages', LanguageController::class);
        Route::resource('topics', TopicController::class);
    });
});

/** Instructor Dashboard */
Route::prefix('/v1/instructor-dashboard/')->middleware(['auth:sanctum', 'instructor'])->name('api.instructor-dashboard.')->group(function () {
    Route::resource('courses', InstructorCourseController::class);
    Route::get('courses/{course_id}/students', [InstructorCourseController::class, 'getStudents'])->name('course.students')->middleware('course.owner');
    Route::resource('courses/{course_id}/sections', SectionController::class)->middleware('course.owner');
    Route::resource('courses/{course_id}/sections/{section_id}/lessons', LessonController::class)->middleware('course.owner');
    Route::resource('courses/{course_id}/faqs', CourseFaqController::class)->middleware('course.owner');
});

/** Leanrer Side */
Route::prefix('/v1')->middleware(['auth:sanctum'])->name('api.learner-side.')->group(function () {
    /** Course List, Detail, Enroll */
    Route::get('home/courses', [LeanerSideHomeController::class, 'index'])->name('courses.index');
    Route::get('home/courses/{slug}', [LeanerSideHomeController::class, 'courseDetail'])->name('courses.show');
    Route::get('home/courses/{slug}/content', [LeanerSideHomeController::class, 'getCourseContent'])->name('courses.content');
    Route::post('home/courses/{course_id}/enroll', [LeanerSideHomeController::class, 'enrollCourse'])->name('courses.enroll');

    Route::prefix('my-learning')->name('my-learning.')->group(function () {
        Route::get('', [MyLearningController::class, 'index'])->name('index');
        Route::get('courses/{course_id}/lessons/{slug}', [MyLearningController::class, 'lessonDetail'])->middleware('course.enrolled')->name('lessons.show');
        Route::post('courses/{course_id}/lessons/{lesson_id}/complete', [MyLearningController::class, 'completeLesson'])->middleware('course.enrolled')->name('lessons.complete');
    });
});
