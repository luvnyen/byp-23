<?php

namespace App\Repositories\Student;

use App\Models\Student\Student;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    /*
        Add new repositories
        OR
        Override existing repository here...
    */
}