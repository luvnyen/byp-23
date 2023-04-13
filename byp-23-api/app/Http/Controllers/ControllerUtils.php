<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ControllerUtils
{
    public static function validateRequest(Model $model, $request)
    {
        $validator = Validator::make(
            $request->only($model->getFillable()),
            $model->validationRules(),
            $model->validationMessages(),
        );
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function validateFilterParams($model, $filterParams)
    {
        if (! empty($filterParams)) {
            foreach ($filterParams as $key => $value) {
                if (substr($key, -3) == '_id') {
                    throw new \Exception('Filter hanya boleh dilakukan pada atribut yang bukan merupakan ID');
                }

                if (! in_array($key, $model->getFillable())) {
                    throw new \Exception(sprintf(
                        'Parameter %s tidak valid',
                        $key
                    ));
                }
            }
        }
    }
}
