<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Models\Student\Student;

class StudentController extends BaseController
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}