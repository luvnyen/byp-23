<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\Student\UnitSeeder;
use Database\Seeders\Student\CourseSeeder;
use Database\Seeders\Student\StudentSeeder;
use Database\Seeders\Student\StudentCourseDetailsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitSeeder::class,
            CourseSeeder::class,
            StudentSeeder::class,
            StudentCourseDetailsSeeder::class,
        ]);
    }
}
