<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject\FilterQueryParam;

final class ProductsFilterQueryParam extends FilterQueryParam
{
    public static function getAvailableFilters(): array
    {
        return ['id', 'name'];
    }
}
