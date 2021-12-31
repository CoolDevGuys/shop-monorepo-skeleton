<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Infrastructure\Persistence\Doctrine;

use CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use CoolDevGuys\Shop\Shared\Domain\Products\ProductId;

final class ProductIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ProductId::class;
    }
}
