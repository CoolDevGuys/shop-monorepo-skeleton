<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application\Find;

use CoolDevGuys\Shared\Domain\Bus\Query\QueryHandler;
use CoolDevGuys\Shared\Domain\Criteria\Criteria;
use CoolDevGuys\Shared\Domain\Criteria\Filters;
use CoolDevGuys\Shared\Domain\Criteria\Order;

final class AllProductsPaginatedQueryHandler implements QueryHandler
{
    public function __construct(private ProductsFinder $productsFinder)
    {
    }

    public function __invoke(AllProductsPaginatedQuery $query): AllProductsPaginatedResponse
    {
        $filters = new Filters([]);
        $offset = ($query->limit() * $query->cursor()) - $query->limit();
        $offset = $offset < 0 ? 0 : $offset;
        $criteria = new Criteria($filters, Order::none(), $offset, $query->limit());
        $paginatedCollection = $this->productsFinder->searchPaginated($criteria);
        return new AllProductsPaginatedResponse($paginatedCollection);
    }
}
