<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Models\Student\StudentCourseDetails;

class StudentCourseDetailsController extends BaseController
{
    public function __construct(StudentCourseDetails $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */

    public function getByStudentId($studentId)
    {
        $data = $this->service->getByStudentId($studentId);

        return $this->success($data);
    }
}