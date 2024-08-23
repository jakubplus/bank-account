<?php

namespace ValueObject;

use App\Domain\ValueObject\TransactionDate;
use PHPUnit\Framework\TestCase;

class TransactionDateTest extends TestCase
{
    public function testTransactionDateEquality()
    {
        $date1 = new \DateTimeImmutable('2024-08-23');
        $date2 = new \DateTimeImmutable('2024-08-23');
        $date3 = new \DateTimeImmutable('2024-08-24');

        $transactionDate1 = new TransactionDate($date1);
        $transactionDate2 = new TransactionDate($date2);
        $transactionDate3 = new TransactionDate($date3);

        $this->assertTrue($transactionDate1->equals($transactionDate2));
        $this->assertFalse($transactionDate1->equals($transactionDate3));
    }
}