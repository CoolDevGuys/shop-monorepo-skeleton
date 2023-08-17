<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Infrastructure\Persistence\Doctrine;

use CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine\TextType;
use CoolDevGuys\Shop\Products\Domain\ValueObject\ProductName;

final class ProductNameDoctrineType extends TextType
{
    protected function typeClassName(): string
    {
        return ProductName::class;
    }
}
