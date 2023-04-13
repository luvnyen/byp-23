<?php

namespace Database\Seeders\Student;

use App\Models\Student\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Informatika',
            ],
            [
                'name' => 'Sistem Informasi Bisnis',
            ],
            [
                'name' => 'Data Science and Analytics',
            ],
        ];
        foreach ($units as $unit) {
            Unit::factory()->create($unit);
        }
    }
}