<?php

namespace ValueObject;

use App\Domain\ValueObject\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testValidCurrencyCode()
    {
        $currency = new Currency('USD');
        $this->assertEquals('USD', $currency->getCode());
    }

    public function testInvalidCurrencyCode()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Currency('INVALID');
    }

    public function testCurrencyEquality()
    {
        $currency1 = new Currency('USD');
        $currency2 = new Currency('USD');
        $currency3 = new Currency('EUR');

        $this->assertTrue($currency1->equals($currency2));
        $this->assertFalse($currency1->equals($currency3));
    }
}