<?php

use App\Models\Student\Unit;
use Illuminate\Http\Request;
use App\Models\Student\Course;
use App\Models\Student\Student;
use Illuminate\Support\Facades\Route;
use App\Models\Student\StudentCourseDetails;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\StudentCourseDetailsController;

require_once 'utils.php';

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


// /units
createCRUDRoute(new Unit());

// /students
createCRUDRoute(new Student());

// /courses
createCRUDRoute(new Course());

// /student-course-details
createCRUDRoute(new StudentCourseDetails());

Route::get(
    '/students/{studentId}/courses',
    [
        StudentCourseDetailsController::class,
        'getByStudentId',
    ]
);

Route::get(
    '/courses/units/{unitId}',
    [
        CourseController::class,
        'getByUnitId',
    ]
);