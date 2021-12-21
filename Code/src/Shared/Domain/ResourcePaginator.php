<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface ResourcePaginator
{
    public function results();

    public function setMaxPerPage(int $number): void;

    public function setCurrentPage(int $page): void;

    public function currentPage();

    public function nextPage(): ?int;
}
