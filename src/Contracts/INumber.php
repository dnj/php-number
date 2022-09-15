<?php

namespace dnj\Number\Contracts;

interface INumber extends \Stringable
{
    public static function formString(string $value, ?int $scale = null): self;

    public static function fromInt(int $value): self;

    public static function fromFloat(float $value, int $scale): self;

    public static function fromOther(self $other, ?int $scale = null): self;

    public static function fromInput(string|int|float|self $input): self;

    public function getInt(): int;

    public function getFloat(): float;

    public function getScale(): int;

    public function getValue(): int|float;

    public function add(string|int|float|self $other, ?int $scale = null): self;

    public function sub(string|int|float|self $other, ?int $scale = null): self;

    public function pow(string|int|float|self $exponent, ?int $scale = null): self;

    public function div(string|int|float|self $other, ?int $scale = null): self;

    public function mul(string|int|float|self $other, ?int $scale = null): self;

    public function compare(string|int|float|self $other, ?int $scale = null): int;

    public function isEqual(string|int|float|self $other, ?int $scale = null): bool;

    public function gt(string|int|float|self $other, ?int $scale = null): bool;

    public function gte(string|int|float|self $other, ?int $scale = null): bool;

    public function eq(string|int|float|self $other, ?int $scale = null): bool;

    public function lt(string|int|float|self $other, ?int $scale = null): bool;

    public function lte(string|int|float|self $other, ?int $scale = null): bool;
}
