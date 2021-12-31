<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shared\Domain\ValueObject\FloatValueObject;
use CoolDevGuys\Shop\Products\Domain\Errors\InvalidPriceError;

final class ProductPrice extends FloatValueObject
{
    public function __construct(float $price)
    {
        $this->guard($price);
        parent::__construct($price);
    }

    private function guard(float $price): void
    {
        if ($price < 0) {
            throw new InvalidPriceError($price);
        }
    }
}
