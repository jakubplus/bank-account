<?php

namespace App\Domain\ValueObject;

use DateTimeImmutable;

class TransactionDate
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param TransactionDate $otherDate
     * @return bool
     */
    public function equals(TransactionDate $otherDate): bool
    {
        return $this->date->format('Y-m-d') === $otherDate->getDate()->format('Y-m-d');
    }
}