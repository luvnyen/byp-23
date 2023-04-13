<?php

namespace App\Services;

class ServiceUtils
{
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
