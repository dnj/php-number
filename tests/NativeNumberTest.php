<?php

namespace dnj\Number\Tests;

use dnj\Number\NativeNumber;
use PHPUnit\Framework\TestCase;

final class NativeNumberTest extends TestCase
{
    public function test(): void
    {
        $this->assertSame(1, NativeNumber::fromInt(1)->getInt());
        $this->assertSame(10, NativeNumber::formString('10')->getValue());
        $this->assertSame(10.521, NativeNumber::formString('10.521')->getValue());
        $this->assertSame(10.52, NativeNumber::formString('10.521', 2)->getValue());
        $this->assertSame(1, NativeNumber::fromFloat(1.0005, 3)->getInt());
        // $this->assertSame(1.000, NativeNumber::fromFloat(1.0005, 3)->getFloat());
        $a = NativeNumber::fromFloat(0.1, 10);
        $b = NativeNumber::fromFloat(0.2, 10);
        $c = NativeNumber::fromFloat(0.3, 10);
        $this->assertSame($c->getValue(), $a->add($b)->getValue());
        $this->assertSame($b->getValue(), $c->sub($a)->getValue());
        $this->assertSame('0.3', NativeNumber::fromOther($c, 3)->__toString());
        $this->assertSame('10', NativeNumber::fromInput(10)->__toString());
        $this->assertSame('10.212', NativeNumber::fromInput(10.212)->__toString());
        $this->assertSame('0.3', NativeNumber::fromInput($c)->__toString());
        $this->assertSame('1', NativeNumber::fromInput('1')->__toString());
        $this->assertSame('0', NativeNumber::fromInput(0.1)->mul(NativeNumber::fromInput(0.2))->__toString());
        $this->assertSame('0.02', NativeNumber::fromInput(0.1)->mul(NativeNumber::fromInput(0.2), 2)->__toString());
        $this->assertSame('3', NativeNumber::fromInput(10)->div(NativeNumber::fromInput(3))->__toString());
        $this->assertSame('3.33', NativeNumber::fromInput(10)->div(NativeNumber::fromInput(3), 2)->__toString());
        $this->assertSame('4', NativeNumber::fromInput(2)->pow(NativeNumber::fromInput(2))->__toString());
        $this->assertFalse(NativeNumber::fromInput('2.002')->isEqual(NativeNumber::fromInput(2)));
        $this->assertTrue(NativeNumber::fromInput('2.002')->isEqual(NativeNumber::fromInput(2), 0));
    }
}
