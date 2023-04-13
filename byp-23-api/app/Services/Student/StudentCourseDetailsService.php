<?php

namespace App\Services\Student;

use App\Models\Student\StudentCourseDetails;
use App\Services\BaseService;

class StudentCourseDetailsService extends BaseService
{
    public function __construct(StudentCourseDetails $model)
    {
        parent::__construct($model);
    }

    /*
        Add new services
        OR
        Override existing service here...
    */

    // override 

    public function getByStudentId($studentId)
    {
        return $this->repository->getByStudentId($studentId);
    }
}