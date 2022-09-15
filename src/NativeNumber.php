<?php

namespace dnj\Number;

use dnj\Number\Contracts\INumber;

class NativeNumber implements INumber
{
    use NumberTrait;

    public static function formString(string $value, ?int $scale = null): self
    {
        $dot = strpos($value, '.');
        if (false !== $dot) {
            $value = floatval($value);
            if (null === $scale) {
                $scale = strlen($value) - $dot - 1;
            }
        } else {
            $value = intval($value);
            $scale = 0;
        }

        return new self($value, $scale);
    }

    public static function fromInt(int $value): self
    {
        return new self($value, 0);
    }

    public static function fromFloat(float $value, int $scale): self
    {
        return new self($value, $scale);
    }

    public static function fromOther(INumber $other, ?int $scale = null): self
    {
        return new self($other->getValue(), $scale ?? $other->getScale());
    }

    public static function fromInput(string|int|float|INumber $input): self
    {
        switch (gettype($input)) {
            case 'string':
                return self::formString($input);
            case 'integer':
                return self::fromInt($input);
            case 'double':
                return self::formString(strval($input));
            default:
                return self::fromOther($input);
        }
    }

    public static function format(float $number, int $scale): float
    {
        return round($number, $scale);
    }

    public function __construct(protected int|float $value, protected int $scale)
    {
    }

    public function getInt(): int
    {
        return $this->value;
    }

    public function getFloat(): float
    {
        return self::format($this->value, $this->scale);
    }

    public function getValue(): int|float
    {
        return 0 === $this->scale ? $this->getInt() : $this->getFloat();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getScale(): int
    {
        return $this->scale;
    }

    public function add(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self($this->value + $other->getValue(), $scale);
    }

    public function sub(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self($this->value - $other->getValue(), $scale);
    }

    public function pow(string|int|float|INumber $exponent, ?int $scale = null): self
    {
        $exponent = Number::fromInput($exponent);
        if (null === $scale) {
            $scale = max($this->scale, $exponent->getScale());
        }

        return new self(pow($this->value, $exponent->getValue()), $scale);
    }

    public function div(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self($this->value / $other->getValue(), $scale);
    }

    public function mul(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self($this->value * $other->getValue(), $scale);
    }

    public function compare(string|int|float|INumber $other, ?int $scale = null): int
    {
        $other = Number::fromInput($other);

        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }
        $me = $this;
        if ($scale !== $this->scale) {
            $me = self::fromOther($this, $scale);
        }
        if ($scale !== $other->getScale()) {
            $me = self::fromOther($other, $scale);
        }

        if ($me->getValue() === $other->getValue()) {
            return 0;
        }

        if ($me->getValue() >= $other->getValue()) {
            return 1;
        }

        return -1;
    }
}
