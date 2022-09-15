<?php

namespace dnj\Number\Tests;

use dnj\Number\BCNumber;
use PHPUnit\Framework\TestCase;

final class BCNumberTest extends TestCase
{
    public function test(): void
    {
        $this->assertSame(1, BCNumber::fromInput(1)->getValue());
        $this->assertSame(10, BCNumber::fromInput('10')->getValue());
        $this->assertSame(1.1, BCNumber::fromInput('1.1')->getValue());
        $this->assertSame(1.1, BCNumber::fromFloat(1.1, 2)->getValue());
        $this->assertSame(1.0, BCNumber::fromFloat(1, 2)->getValue());
        $this->assertSame(0.1, BCNumber::fromInput(0.1)->getValue());
        $this->assertSame(1, BCNumber::fromInput(BCNumber::fromInt(1))->getValue());

        $a = BCNumber::fromFloat(0.1, 10);
        $b = BCNumber::fromFloat(0.2, 10);
        $c = BCNumber::fromFloat(0.3, 10);
        $this->assertTrue($a->add($b)->isEqual($c));
        $this->assertSame($b->getValue(), $c->sub($a)->getValue());
        $this->assertSame(0.03, $c->mul($a)->getValue());
        $this->assertSame(3.0, $c->div($a)->getValue());
        $this->assertSame(0.09, $c->pow(2)->getValue());
    }
}
