<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shared\Domain\Collection;

final class Products extends Collection
{
    protected function type(): string
    {
        return Product::class;
    }
}
