<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface PaginatedCollection
{
    public function total(): int;

    public function totalPages(): int;

    public function currentPage(): int;

    public function maxPerPage(): int;

    public function nextPage(): ?int;

    public function data(): Collection;
}
