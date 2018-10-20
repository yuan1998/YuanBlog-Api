<?php

namespace App\Validations;

use App\Models\Category;

class EmptyValidator extends \Illuminate\Validation\Validator {

    public function validateEmpty ($att , $value)
    {
        return ! $this->validateRequired($att , $value);
    }


    public function validateEmptyIf ($att,$value , $param)
    {
        $key = $param[0];

        if ($this->validateRequired($key, $this->getValue($key))) {
            return $this->validateEmpty($att, $value);
        }

        return true;
    }


    public function validateCatParent ($att , $value , $param)
    {
        return !($value != null && !Category::find($value));
    }

}