<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function setModelRoute(Model $model)
{
    $modelName = Str::kebab(class_basename($model));
    $modelNameLower = strtolower($modelName);

    return Str::plural($modelNameLower);
}

function createCRUDRoute(Model $model)
{
    $prefix = setModelRoute($model);
    $controller = $model->controller();

    return Route::group([
        'prefix' => $prefix,
    ], function () use ($controller) {
        Route::get(
            '/',
            [$controller, 'index']
        );

        Route::post(
            '/',
            [$controller, 'store']
        );

        Route::get(
            '/{id}',
            [$controller, 'show']
        )->middleware('validate.uuid');

        Route::put(
            '/{id}',
            [$controller, 'update']
        )->middleware('validate.uuid');

        Route::delete(
            '/{id}',
            [$controller, 'destroy']
        )->middleware('validate.uuid');
    });
}
