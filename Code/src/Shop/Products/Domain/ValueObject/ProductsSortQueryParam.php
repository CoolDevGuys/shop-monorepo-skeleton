<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject\SortQueryParam;

final class ProductsSortQueryParam extends SortQueryParam
{
    protected function supportedSortValuesMapping(): array
    {
        return ['name' => 'name'];
    }
}
