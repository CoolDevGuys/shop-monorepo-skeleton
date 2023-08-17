<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject\AbstractSortQueryParam;

final class ProductsAbstractSortQueryParam extends AbstractSortQueryParam
{
    protected function supportedSortValuesMapping(): array
    {
        return ['name' => 'name'];
    }
}
