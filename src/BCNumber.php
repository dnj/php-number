<?php

namespace dnj\Number;

use dnj\Number\Contracts\INumber;

class BCNumber implements INumber
{
    use NumberTrait;

    public static function formString(string $value, ?int $scale = null): self
    {
        $dot = strpos($value, '.');
        if (false !== $dot) {
            if (null === $scale) {
                $scale = strlen($value) - $dot - 1;
            }
        } else {
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
        return new self($other->__toString(), $scale ?? $other->getScale());
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

    public function __construct(protected string $value, protected int $scale)
    {
    }

    public function getInt(): int
    {
        return intval($this->value);
    }

    public function getFloat(): float
    {
        $dot = strpos($this->value, '.');
        $decimals = false === $dot ? 0 : (strlen($this->value) - $dot - 1);
        $value = $this->value;
        if ($this->scale > $decimals) {
            if (0 === $decimals) {
                $value .= '.';
            }
            $value .= str_repeat('0', $this->scale - $decimals);
        } elseif ($decimals > $this->scale) {
            if (0 === $this->scale) {
                $value = substr($value, 0, $dot);
            } else {
                $value = substr($value, 0, $dot + 1 + $this->scale);
            }
        }

        return floatval($value);
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

        return new self(bcadd($this->value, $other->__toString(), $scale), $scale);
    }

    public function sub(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self(bcsub($this->value, $other->__toString(), $scale), $scale);
    }

    public function pow(string|int|float|INumber $exponent, ?int $scale = null): self
    {
        $exponent = Number::fromInput($exponent);
        if (null === $scale) {
            $scale = max($this->scale, $exponent->getScale());
        }

        return new self(bcpow($this->value, $exponent->__toString(), $scale), $scale);
    }

    public function div(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self(bcdiv($this->value, $other->__toString(), $scale), $scale);
    }

    public function mul(string|int|float|INumber $other, ?int $scale = null): self
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return new self(bcmul($this->value, $other->__toString(), $scale), $scale);
    }

    public function compare(string|int|float|INumber $other, ?int $scale = null): int
    {
        $other = Number::fromInput($other);
        if (null === $scale) {
            $scale = max($this->scale, $other->getScale());
        }

        return bccomp($this->value, $other->__toString(), $scale);
    }
}
