<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Currency
{
    private string $code;

    public function __construct(string $code)
    {
        if (!in_array($code, ['USD', 'EUR', 'GBP', 'JPY', 'AUD'])) {
            throw new InvalidArgumentException('Unsupported currency.');
        }
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function equals(Currency $currency): bool
    {
        return $this->code === $currency->getCode();
    }
}