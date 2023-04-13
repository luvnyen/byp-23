<?php

namespace Database\Seeders\Student;

use App\Models\Student\Unit;
use App\Models\Student\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitInformatika = Unit::where('name', 'Informatika')->first();
        $unitSIB = Unit::where('name', 'Sistem Informasi Bisnis')->first();
        $unitDSA = Unit::where('name', 'Data Science and Analytics')->first();
        
        $students = [
            [
                'name' => 'Christopher Julius',
                'nrp' => 'c14210073',
                'unit_id' => $unitSIB->id,
            ],
            [
                'name' => 'Kelvin Sidharta Sie',
                'nrp' => 'c14210074',
                'unit_id' => $unitInformatika->id,
            ],
            [
                'name' => 'Emily Joyceline',
                'nrp' => 'c14210077',
                'unit_id' => $unitDSA->id,
            ],
            [
                'name' => 'Vincentius Rio',
                'nrp' => 'c14210006',
                'unit_id' => $unitInformatika->id,
            ],
        ];
        foreach ($students as $student) {
            Student::factory()->create($student);
        }
    }
}