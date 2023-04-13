<?php

namespace App\Repositories\Student;

use App\Models\Student\Unit;
use App\Repositories\BaseRepository;

class UnitRepository extends BaseRepository
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    /*
        Add new repositories
        OR
        Override existing repository here...
    */
}