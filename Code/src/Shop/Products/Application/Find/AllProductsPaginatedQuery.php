<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application\Find;

use CoolDevGuys\Shared\Domain\Bus\Query\Query;

final class AllProductsPaginatedQuery implements Query
{
    public function __construct(private int $limit, private int $cursor, private ?string $q)
    {
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function cursor(): int
    {
        return $this->cursor;
    }

    public function q(): ?string
    {
        return $this->q;
    }
}
