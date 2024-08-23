<?php

namespace Entity;

use App\Domain\Entity\BankAccount;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\TransactionDate;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BankAccountTest extends TestCase
{
    public function testAccountCreationWithInitialBalance()
    {
        $currency = new Currency('USD');
        $initialBalance = new Money(1000, $currency);
        $account = new BankAccount($initialBalance);

        $this->assertEquals(1000, $account->getBalance()->getAmount());
        $this->assertEquals('USD', $account->getCurrency()->getCode());
    }

    public function testCreditMoney()
    {
        $currency = new Currency('USD');
        $initialBalance = new Money(1000, $currency);
        $account = new BankAccount($initialBalance);

        $creditAmount = new Money(500, $currency);
        $account->credit($creditAmount);

        $this->assertEquals(1500, $account->getBalance()->getAmount());
    }

    public function testDebitMoney()
    {
        $currency = new Currency('USD');
        $initialBalance = new Money(1000, $currency);
        $account = new BankAccount($initialBalance);

        $debitAmount = new Money(100, $currency);
        $transactionDate = new TransactionDate(new DateTimeImmutable('now'));
        $account->debit($debitAmount, $transactionDate);

        $expectedBalance = 1000 - 100 - (100 * 0.0005); // 1000 - 100 - 0.05
        $this->assertEquals($expectedBalance, $account->getBalance()->getAmount());
    }

    public function testDebitMoneyInsufficientFunds()
    {
        $currency = new Currency('USD');
        $initialBalance = new Money(100, $currency);
        $account = new BankAccount($initialBalance);

        $debitAmount = new Money(200, $currency);
        $transactionDate = new TransactionDate(new DateTimeImmutable('now'));

        $this->expectException(\InvalidArgumentException::class);
        $account->debit($debitAmount, $transactionDate);
    }

    public function testDailyTransactionLimit()
    {
        $currency = new Currency('USD');
        $initialBalance = new Money(1000, $currency);
        $account = new BankAccount($initialBalance);

        $debitAmount = new Money(100, $currency);
        $transactionDate = new TransactionDate(new DateTimeImmutable('now'));

        // Perform 3 successful transactions
        $account->debit($debitAmount, $transactionDate);
        $account->debit($debitAmount, $transactionDate);
        $account->debit($debitAmount, $transactionDate);

        // 4th transaction should throw an exception
        $this->expectException(RuntimeException::class);
        $account->debit($debitAmount, $transactionDate);
    }

    public function testCurrencyMismatchInDebit()
    {
        $currencyUSD = new Currency('USD');
        $currencyEUR = new Currency('EUR');
        $initialBalance = new Money(1000, $currencyUSD);
        $account = new BankAccount($initialBalance);

        $debitAmount = new Money(100, $currencyEUR);
        $transactionDate = new TransactionDate(new DateTimeImmutable('now'));

        $this->expectException(\InvalidArgumentException::class);
        $account->debit($debitAmount, $transactionDate);
    }
}