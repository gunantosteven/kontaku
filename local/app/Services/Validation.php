<?php namespace app\Services;

use Illuminate\Validation\Validator;

class Validation extends Validator {

    public function validatePhone($attribute, $value, $parameters)
    {
        return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
    }

}