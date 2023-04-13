<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentCourseController extends Controller
{
    public function index($studentId)
    {
        $url = sprintf(
            'http://localhost:8000/api/students/%s/courses',
            $studentId
        );
        $data = Http::get($url);
        
        return view(
            'pages.student_course', 
            [
                'data' => $data['data']
            ]
        );
    }

    public function getByUnitId($unitId)
    {
        $url = sprintf(
            'http://localhost:8000/api/courses/units/%s',
            $unitId
        );
        $data = Http::get($url);

        return view(
            'pages.student_course', 
            [
                'data' => $data['data']
            ]
        );
    }

    public function store(Request $request, $studentId)
    {
        $url = 'http://localhost:8000/api/student-course-details';
        return Http::post($url, [
            'student_id' => $studentId,
            'course_id' => $request->course_id,
        ]);
    }
}
