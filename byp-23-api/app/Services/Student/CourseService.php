<?php

namespace App\Services\Student;

use App\Models\Student\Course;
use App\Services\BaseService;

class CourseService extends BaseService
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /*
        Add new services
        OR
        Override existing service here...
    */

    public function getByUnitId($unitId)
    {
        return $this->resource::collection(
            $this->repository->getByUnitId($unitId)
        );
    }
}