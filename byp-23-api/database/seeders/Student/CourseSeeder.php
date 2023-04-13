<?php

namespace Database\Seeders\Student;

use App\Models\Student\Unit;
use App\Models\Student\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitInformatika = Unit::where('name', 'Informatika')->first();
        $unitSIB = Unit::where('name', 'Sistem Informasi Bisnis')->first();
        $unitDSA = Unit::where('name', 'Data Science and Analytics')->first();

        $courses = [
            [
                'code' => 'INF-101',
                'name' => 'Teori Bahasa dan Automata',
                'unit_id' => $unitInformatika->id,
            ],
            [
                'code' => 'INF-102',
                'name' => 'Desain dan Analisis Algoritma',
                'unit_id' => $unitInformatika->id,
            ],
            [
                'code' => 'SIB-101',
                'name' => 'Matematika Bisnis',
                'unit_id' => $unitSIB->id,
            ],
            [
                'code' => 'SIB-102',
                'name' => 'Sistem Informasi Manajemen',
                'unit_id' => $unitSIB->id,
            ],
            [
                'code' => 'DSA-101',
                'name' => 'Data Mining',
                'unit_id' => $unitDSA->id,
            ],
            [
                'code' => 'DSA-102',
                'name' => 'Presentasi dan Visualisasi Data',
                'unit_id' => $unitDSA->id,
            ],
        ];
        foreach ($courses as $course) {
            Course::factory()->create($course);
        }
    }
}