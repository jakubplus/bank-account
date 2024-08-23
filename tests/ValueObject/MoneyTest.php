<?php

namespace ValueObject;

use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMoneyCreation()
    {
        $currency = new Currency('USD');
        $money = new Money(100, $currency);

        $this->assertEquals(100, $money->getAmount());
        $this->assertEquals($currency, $money->getCurrency());
    }

    public function testAddMoney()
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = new Money(50, $currency);

        $result = $money1->add($money2);
        $this->assertEquals(150, $result->getAmount());
    }

    public function testSubtractMoney()
    {
        $currency = new Currency('USD');
        $money1 = new Money(100, $currency);
        $money2 = new Money(50, $currency);

        $result = $money1->subtract($money2);
        $this->assertEquals(50, $result->getAmount());
    }

    public function testSubtractMoneyInsufficientFunds()
    {
        $currency = new Currency('USD');
        $money1 = new Money(50, $currency);
        $money2 = new Money(100, $currency);

        $this->expectException(\InvalidArgumentException::class);
        $money1->subtract($money2);
    }

    public function testCurrencyMismatchInAddition()
    {
        $currencyUSD = new Currency('USD');
        $currencyEUR = new Currency('EUR');
        $moneyUSD = new Money(100, $currencyUSD);
        $moneyEUR = new Money(100, $currencyEUR);

        $this->expectException(\InvalidArgumentException::class);
        $moneyUSD->add($moneyEUR);
    }
}