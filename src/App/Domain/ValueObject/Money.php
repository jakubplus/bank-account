<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Money
{
    private float $amount;
    private Currency $currency;

    public function __construct(float $amount, Currency $currency)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount must be positive.');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Money $money
     * @return Money
     */
    public function add(Money $money): Money
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new InvalidArgumentException('Currency mismatch.');
        }

        return new Money($this->amount + $money->getAmount(), $this->currency);
    }

    /**
     * @param Money $money
     * @return Money
     */
    public function subtract(Money $money): Money
    {
        if (!$this->currency->equals($money->getCurrency())) {
            throw new InvalidArgumentException('Currency mismatch.');
        }

        if ($this->amount < $money->getAmount()) {
            throw new InvalidArgumentException('Insufficient funds.');
        }

        return new Money($this->amount - $money->getAmount(), $this->currency);
    }

    /**
     * @param Money $money
     * @return bool
     */
    public function equals(Money $money): bool
    {
        return $this->currency->equals($money->getCurrency()) && $this->amount === $money->getAmount();
    }
}