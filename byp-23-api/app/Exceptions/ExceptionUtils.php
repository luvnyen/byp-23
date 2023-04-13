<?php

namespace App\Exceptions;

class ExceptionUtils
{
    public static function getErrorFieldName($e)
    {
        $field = explode('(', $e->errorInfo[2])[1];
        $field = explode(')', $field)[0];

        return $field;
    }

    public static function getErrorFieldValue($e)
    {
        $value = explode('(', $e->errorInfo[2])[2];
        $value = explode(')', $value)[0];

        return $value;
    }
}
