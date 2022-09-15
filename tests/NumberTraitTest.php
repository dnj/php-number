<?php
namespace dnj\Number\Tests;

use dnj\Number\Number;
use PHPUnit\Framework\TestCase;

class NumberTraitTest extends TestCase {
	public function test() {
		$a = Number::fromInput(0.1);
		$b = Number::fromInput(0.2);
		$this->assertTrue($b->gt($a));
		$this->assertTrue($b->gte($a));
		$this->assertTrue($a->lt($b));
		$this->assertTrue($b->lte($b));
		$this->assertTrue($b->eq($b));
	}
}
