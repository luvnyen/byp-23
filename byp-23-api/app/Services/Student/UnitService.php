<?php

namespace App\Services\Student;

use App\Models\Student\Unit;
use App\Services\BaseService;

class UnitService extends BaseService
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    /*
        Add new services
        OR
        Override existing service here...
    */
}