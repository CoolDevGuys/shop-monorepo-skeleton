<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

use CoolDevGuys\Shared\Domain\Criteria\Criteria;

final class PaginatedByCriteriaCollection implements PaginatedCollection
{
    private Criteria $criteria;
    private $searchFunction;
    private ?int $total;
    private $counterFunction;

    public function __construct(Criteria $criteria, callable $fetcherFunction, callable $counterFunction)
    {
        $this->total = null;
        $this->criteria = $criteria;
        $this->searchFunction = $fetcherFunction;
        $this->counterFunction = $counterFunction;
    }

    public function total(): int
    {
        if (null !== $this->total) {
            return $this->total;
        }
        $filters = $this->criteria->filters();
        $order = $this->criteria->order();
        $criteria = new Criteria($filters, $order, null, null);
        $this->total = call_user_func($this->counterFunction, $criteria);

        return $this->total;
    }

    public function currentPage(): int
    {
        return ((int)floor($this->criteria->offset() / $this->criteria->limit())) + 1;
    }

    public function nextPage(): ?int
    {
        $nextPage = $this->currentPage() + 1;

        $totalPages = $this->totalPages();
        if ($nextPage < $totalPages) {
            return $nextPage;
        }
        return null;
    }

    public function data(): Collection
    {
        return call_user_func($this->searchFunction, $this->criteria);
    }

    public function totalPages(): int
    {
        return (int)ceil($this->total() / $this->criteria->limit());
    }

    public function maxPerPage(): int
    {
        return $this->criteria->limit();
    }
}
