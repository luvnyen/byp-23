<?php

namespace Database\Seeders\Student;

use App\Models\Student\Course;
use App\Models\Student\Student;
use Illuminate\Database\Seeder;
use App\Models\Student\StudentCourseDetails;

class StudentCourseDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentCJ = Student::where('name', 'Christopher Julius')->first();
        $studentKelvin = Student::where('name', 'Kelvin Sidharta Sie')->first();
        $studentEmily = Student::where('name', 'Emily Joyceline')->first();
        $studentVincent = Student::where('name', 'Vincentius Rio')->first();

        $courseTBA = Course::where('name', 'Teori Bahasa dan Automata')->first();
        $courseDAA = Course::where('name', 'Desain dan Analisis Algoritma')->first();
        $courseMB = Course::where('name', 'Matematika Bisnis')->first();
        $courseDM = Course::where('name', 'Data Mining')->first();
        
        $studentCourseDetails = [
            [
                'student_id' => $studentCJ->id,
                'course_id' => $courseMB->id,
            ],
            [
                'student_id' => $studentKelvin->id,
                'course_id' => $courseDAA->id,
            ],
            [
                'student_id' => $studentKelvin->id,
                'course_id' => $courseTBA->id,
            ],
            [
                'student_id' => $studentEmily->id,
                'course_id' => $courseDM->id,
            ],
            [
                'student_id' => $studentVincent->id,
                'course_id' => $courseDAA->id,
            ],
        ];
        foreach ($studentCourseDetails as $studentCourseDetails) {
            StudentCourseDetails::factory()->create($studentCourseDetails);
        }
    }
}