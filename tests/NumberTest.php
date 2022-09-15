<?php

namespace dnj\Number\Tests;

use dnj\Number\Number;
use PHPUnit\Framework\TestCase;

final class NumberTest extends TestCase
{
    public function test(): void
    {
        $this->assertSame(1.0, Number::fromFloat(1.01, 1)->getValue());
        $this->assertSame(10, Number::fromInt(10)->getValue());
        $this->assertSame(10.2, Number::formString('10.2')->getValue());
        $a = Number::fromInt(10);
        $this->assertSame(10, Number::fromOther($a)->getValue());
        $this->assertSame($a, Number::fromInput($a));
    }
}
