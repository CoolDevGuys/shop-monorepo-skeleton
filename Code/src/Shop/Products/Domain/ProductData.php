<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shop\Products\Domain\ValueObject\ProductName;

final class ProductData
{
    public function __construct(private ?ProductName $name = null, private ?ProductPrice $price = null)
    {
    }

    public function name(): ?ProductName
    {
        return $this->name;
    }

    public function price(): ?ProductPrice
    {
        return $this->price;
    }

    public function properties(): array
    {
        return get_object_vars($this);
    }
}
