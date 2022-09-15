<?php

namespace dnj\Number\Laravel\Casts;

use dnj\Number\Contracts\INumber;
use dnj\Number\Number as NumberFacade;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Number implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return INumber
     */
    public function get($model, $key, $value, $attributes)
    {
        return NumberFacade::fromInput($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param INumber                             $value
     * @param array                               $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if ($value instanceof INumber) {
            return $value->__toString();
        }

        return $value;
    }
}
