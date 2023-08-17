<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shared\Domain\Collection;
use function Lambdish\Phunctional\map;

final class Products extends Collection
{
    protected function type(): string
    {
        return Product::class;
    }

    public function toArray(): array
    {
        return map(fn(Product $product) => $product->toArray(), $this->items());
    }
}
