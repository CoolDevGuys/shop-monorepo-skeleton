<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Criteria;

use CoolDevGuys\Shared\Domain\Errors\InvalidCriteriaLimitError;

final class Criteria
{
    private const MAX_LIMIT = 50;
    private ?int $limit;

    public function __construct(private Filters $filters, private Order $order, private ?int $offset, ?int $limit)
    {
        $this->guardLimit($limit);
        $this->limit = $limit ?? self::MAX_LIMIT;
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function plainFilters(): array
    {
        return $this->filters->filters();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset,
            $this->limit
        );
    }

    private function guardLimit(?int $limit): void
    {
        if (null !== $limit && $limit > self::MAX_LIMIT) {
            throw new InvalidCriteriaLimitError($limit, self::MAX_LIMIT);
        }
    }
}
