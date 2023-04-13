<?php

namespace App\Models\Student;

use App\Models\Student\Course;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Student\CourseResource;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Services\Student\StudentCourseDetailsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\Student\StudentCourseDetailsResource;
use App\Repositories\Student\StudentCourseDetailsRepository;

class StudentCourseDetails extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
    ];

    public static function validationRules()
    {
        return [
            'student_id' => [
                'required',
                'uuid',
            ],
            'course_id' => [
                'required',
                'uuid',
            ],
        ];
    }

    public static function validationMessages()
    {
        return [
            'student_id.required' => 'Mahasiswa harus diisi',
            'student_id.uuid' => 'Mahasiswa harus berupa UUID',
            'course_id.required' => 'Mata kuliah harus diisi',
            'course_id.uuid' => 'Mata kuliah harus berupa UUID',
        ];
    }

    public function test()
    {
        $student = new Student();
        $student = $student::create($student->test());

        $course = new Course();
        $course = $course::create($course->test());

        return [
            'student_id' => $student->id,
            'course_id' => $course->id,
        ];
    }

    public function resourceData($request)
    {
        return [
            'id' => $request->id,
            'student' => new StudentResource($request->student),
            'course' => new CourseResource($request->course),
        ];
    }

    public function controller()
    {
        return 'App\Http\Controllers\Student\StudentCourseDetailsController';
    }

    public function service()
    {
        return new StudentCourseDetailsService($this);
    }

    public function repository()
    {
        return new StudentCourseDetailsRepository($this);
    }

    public function resource()
    {
        return new StudentCourseDetailsResource($this);
    }

    /*
        Define Relationships
    */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
