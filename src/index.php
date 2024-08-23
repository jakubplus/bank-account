<?php

namespace App;

use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\TransactionDate;
use App\Domain\Entity\BankAccount;

// Initialize an account with $1000 USD
$currencyUSD = new Currency('USD');
$initialBalance = new Money(1000, $currencyUSD);
$bankAccount = new BankAccount($initialBalance);

// Credit $500 USD
$creditAmount = new Money(500, $currencyUSD);
$bankAccount->credit($creditAmount);
echo "Balance after credit: {$bankAccount->getBalance()->getAmount()} USD\n";

// Debit $100 USD
$debitAmount = new Money(100, $currencyUSD);
$transactionDate = new TransactionDate(new \DateTimeImmutable('now'));
$bankAccount->debit($debitAmount, $transactionDate);
echo "Balance after debit: {$bankAccount->getBalance()->getAmount()} USD\n";

// Attempt another debit on the same day
$bankAccount->debit($debitAmount, $transactionDate);
echo "Balance after second debit: {$bankAccount->getBalance()->getAmount()} USD\n";

// Attempt a third debit on the same day
$bankAccount->debit($debitAmount, $transactionDate);
echo "Balance after third debit: {$bankAccount->getBalance()->getAmount()} USD\n";

// This will throw an exception due to maximum daily transactions
$bankAccount->debit($debitAmount, $transactionDate);