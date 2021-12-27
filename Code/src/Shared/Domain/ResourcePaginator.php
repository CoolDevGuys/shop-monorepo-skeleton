<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface ResourcePaginator
{
    public function results(): array;

    public function setMaxPerPage(int $number): void;

    public function setCurrentPage(int $page): void;

    public function currentPage(): int;

    public function nextPage(): ?int;
}
