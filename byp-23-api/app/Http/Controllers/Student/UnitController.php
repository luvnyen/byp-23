<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Models\Student\Unit;

class UnitController extends BaseController
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    /*
        Add new controllers
        OR
        Override existing controller here...
    */
}