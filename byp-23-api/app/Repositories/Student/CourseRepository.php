<?php

namespace App\Repositories\Student;

use App\Models\Student\Course;
use App\Repositories\BaseRepository;

class CourseRepository extends BaseRepository
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /*
        Add new repositories
        OR
        Override existing repository here...
    */

    public function getByUnitId($unitId)
    {
        return $this->model->where('unit_id', $unitId)->get();
    }
}