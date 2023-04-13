<?php

namespace Tests;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setModelRoute(Model $model)
    {
        $modelName = Str::kebab(class_basename($model));
        $modelNameLower = strtolower($modelName);
        $modelPlural = Str::plural($modelNameLower);

        return sprintf('/api/%s', $modelPlural);
    }
}
