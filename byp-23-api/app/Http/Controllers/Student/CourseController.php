<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Models\Student\Course;

class CourseController extends BaseController
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */

    public function getByUnitId($unitId)
    {
        $data = $this->service->getByUnitId($unitId);

        return $this->success($data);
    }
}