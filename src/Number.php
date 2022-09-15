<?php

namespace dnj\Number;

use dnj\Number\Contracts\INumber;

class Number
{
    public static function formString(string $value, ?int $scale = null): INumber
    {
        return call_user_func([self::getDriver(), __FUNCTION__], $value, $scale);
    }

    public static function fromInt(int $value): INumber
    {
        return call_user_func([self::getDriver(), __FUNCTION__], $value);
    }

    public static function fromFloat(float $value, int $scale): INumber
    {
        return call_user_func([self::getDriver(), __FUNCTION__], $value, $scale);
    }

    public static function fromOther(INumber $other): INumber
    {
        return call_user_func([self::getDriver(), __FUNCTION__], $other);
    }

    public static function fromInput(string|int|float|INumber $input): INumber
    {
        if ($input instanceof INumber) {
            return $input;
        }

        return call_user_func([self::getDriver(), __FUNCTION__], $input);
    }

    /**
     * @return class-string<INumber>
     */
    public static function getDriver(): string
    {
        if (extension_loaded('bcmath')) {
            return BCNumber::class;
        }

        return NativeNumber::class;
    }
}
