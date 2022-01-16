<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application\Find;

use CoolDevGuys\Shared\Domain\Bus\Query\QueryResponse;
use CoolDevGuys\Shared\Domain\PaginatedByCriteriaCollection;

final class AllProductsPaginatedResponse implements QueryResponse
{
    public function __construct(private PaginatedByCriteriaCollection $products)
    {
    }

    public function products(): PaginatedByCriteriaCollection
    {
        return $this->products;
    }
}
