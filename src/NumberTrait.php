<?php

namespace dnj\Number;

use dnj\Number\Contracts\INumber;

trait NumberTrait
{
    public function isEqual(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return 0 === $this->compare($other, $scale);
    }

    public function eq(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return 0 === $this->compare($other, $scale);
    }

    public function gt(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return $this->compare($other, $scale) > 0;
    }

    public function gte(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return $this->compare($other, $scale) >= 0;
    }

    public function lt(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return $this->compare($other, $scale) < 0;
    }

    public function lte(string|int|float|INumber $other, ?int $scale = null): bool
    {
        return $this->compare($other, $scale) <= 0;
    }
}
