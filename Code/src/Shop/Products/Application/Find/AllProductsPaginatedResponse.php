<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application\Find;

use CoolDevGuys\Shared\Domain\Bus\Query\QueryResponse;
use CoolDevGuys\Shared\Domain\PaginatedByCriteriaCollection;

final class AllProductsPaginatedResponse implements QueryResponse
{
    public function __construct(private PaginatedByCriteriaCollection $products) {}

    public function products(): array
    {
        return $this->products->data()->toArray();
    }

    public function nextPage(): ?int
    {
        return $this->products->nextPage();
    }

    public function currentPage(): int
    {
        return $this->products->currentPage();
    }

    public function totalItems(): int
    {
        return $this->products->total();
    }

    public function totalPages(): int
    {
        return $this->products->totalPages();
    }
}
