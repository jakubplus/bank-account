<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\TransactionDate;
use InvalidArgumentException;
use RuntimeException;

class BankAccount
{
    /**
     * @var Money
     */
    private Money $balance;

    /**
     * @var Currency
     */
    private Currency $currency;

    /**
     * @var int
     */
    private int $dailyTransactionCount;

    /**
     * @var TransactionDate|null
     */
    private ?TransactionDate $lastTransactionDate;

    private const MAX_DAILY_TRANSACTIONS = 3;
    private const TRANSACTION_FEE_PERCENTAGE = 0.0005; // 0.05%

    /**
     * @param Money $initialBalance
     */
    public function __construct(Money $initialBalance)
    {
        $this->balance = $initialBalance;
        $this->currency = $initialBalance->getCurrency();
        $this->dailyTransactionCount = 0;
        $this->lastTransactionDate = null;
    }

    /**
     * @param Money $amount
     * @return void
     */
    public function credit(Money $amount): void
    {
        if (!$this->currency->equals($amount->getCurrency())) {
            throw new InvalidArgumentException('Currency mismatch.');
        }

        $this->balance = $this->balance->add($amount);
    }

    /**
     * @param Money $amount
     * @param TransactionDate $transactionDate
     * @return void
     */
    public function debit(Money $amount, TransactionDate $transactionDate): void
    {
        if (!$this->currency->equals($amount->getCurrency())) {
            throw new InvalidArgumentException('Currency mismatch.');
        }

        if ($this->lastTransactionDate && !$this->lastTransactionDate->equals($transactionDate)) {
            $this->dailyTransactionCount = 0;
        }

        if ($this->dailyTransactionCount >= self::MAX_DAILY_TRANSACTIONS) {
            throw new RuntimeException('Maximum daily transactions reached.');
        }

        $fee = $amount->getAmount() * self::TRANSACTION_FEE_PERCENTAGE;
        $totalAmount = $amount->getAmount() + $fee;
        $totalMoney = new Money($totalAmount, $this->currency);

        $this->balance = $this->balance->subtract($totalMoney);

        $this->dailyTransactionCount++;
        $this->lastTransactionDate = $transactionDate;
    }

    /**
     * @return Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}