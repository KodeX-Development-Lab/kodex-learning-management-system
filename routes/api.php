<?php

use App\Modules\CourseFaq\Http\Controller\Api\CourseFaqController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Auth\Http\Controllers\Api\InstructorController;
use App\Modules\CourseUser\Http\Controller\Api\CourseUserController;
use App\Modules\ProfessionalField\Http\Controller\Api\ProfessionalFieldController;

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

Route::prefix('/v1/auth')->name('api.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });



    Route::prefix('/v1')->group(function () {
        Route::post('instructor/create',[InstructorController::class,'instructorCreate']);
    });

    Route::prefix('/v1')->group(function(){
        Route::post('statusUpdate/{status}',[InstructorController::class,'statusUpdate'])->middleware('CheckAdmin');
    });

    Route::prefix('/v1')->group(function(){
        Route::resource('professionalField',ProfessionalFieldController::class);
    });

    Route::prefix('/v1')->group(function(){
        Route::post('/courses/{id}/enroll/',[CourseUserController::class,'store']);
    });

    Route::prefix('/v1/{course_id}')->group(function(){
        Route::resource('course_faq',CourseFaqController::class);
    });


});
