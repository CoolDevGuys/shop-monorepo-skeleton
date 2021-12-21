<?php

declare(strict_types=1);


namespace CoolDevGuys\Shared\Infrastructure\Doctrine;

use CoolDevGuys\Shared\Domain\ResourcePaginator;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;

final class RawSqlPaginator implements ResourcePaginator
{
    public const DEFAULT_MAX_PER_PAGE = 100;
    public const DEFAULT_CURRENT_PAGE = 1;

    private Statement $sqlStatement;
    private int $currentPage;
    private int $maxPerPage;

    public function __construct(Statement $query)
    {
        $this->sqlStatement = $query;
    }

    public function currentPage()
    {
        return $this->currentPage;
    }

    public function setMaxPerPage(int $number): void
    {
        $this->maxPerPage = $number;
    }

    public function setCurrentPage(int $page): void
    {
        $this->currentPage = $page;
    }

    public function results()
    {
        $limit = $this->maxPerPage ?? self::DEFAULT_MAX_PER_PAGE;
        $offset = (($this->currentPage ?? 1) * $limit) - $limit;
        return $this->execute($limit, $offset);
    }

    public function nextPage(): ?int
    {
        $limit = $this->maxPerPage ?? self::DEFAULT_MAX_PER_PAGE;
        $offset = (self::DEFAULT_CURRENT_PAGE * $limit) - $limit;
        if ($this->currentPage) {
            $offset = (($this->currentPage + 1) * $limit) - $limit;
        }

        $result = $this->execute($limit, $offset);
        $nextPage = null;

        if (!empty($result)) {
            $nextPage = $this->currentPage + 1;
        }
        return $nextPage;
    }

    private function execute(int $limit, int $offset): array
    {
        $this->sqlStatement->bindParam('limit', $limit, ParameterType::INTEGER);
        $this->sqlStatement->bindParam('offset', $offset, ParameterType::INTEGER);
        $this->sqlStatement->execute();
        return $this->sqlStatement->fetchAll(2);
    }
}
