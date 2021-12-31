<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application\Find;

use CoolDevGuys\Shared\Domain\Criteria\Criteria;
use CoolDevGuys\Shared\Domain\Criteria\Filters;
use CoolDevGuys\Shared\Domain\Criteria\Order;
use CoolDevGuys\Shared\Domain\PaginatedByCriteriaCollection;
use CoolDevGuys\Shop\Products\Domain\ProductRepository;
use CoolDevGuys\Shop\Products\Domain\Products;

final class ProductsFinder
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function __invoke(?Criteria $criteria = null): Products
    {
        if (null === $criteria) {
            $criteria = new Criteria(new Filters([]), Order::none(), 0, null);
        }
        return $this->repository->search($criteria);
    }

    public function searchPaginated(Criteria $criteria): PaginatedByCriteriaCollection
    {
        return new PaginatedByCriteriaCollection(
            $criteria,
            function (Criteria $c) {
                return $this->repository->search($c);
            },
            function (Criteria $c) {
                return $this->repository->countByCriteria($c);
            }
        );
    }
}
