<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidPriceError extends DomainError
{
    public function __construct(private float $price)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_price';
    }

    protected function errorMessage(): string
    {
        return sprintf('The provided price value %s is invalid', (string)$this->price);
    }
}
