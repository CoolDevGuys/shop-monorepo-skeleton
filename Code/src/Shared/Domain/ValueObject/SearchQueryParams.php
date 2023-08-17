<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

final readonly class SearchQueryParams
{
    public function __construct(
        private ?PaginationCursorQueryParam $cursor,
        private LimitQueryParam $limit,
        private ?AbstractSortQueryParam $sortQueryParam = null,
        private ?FiltersQueryParam $filters = null,
        private ?SearchableQueryParam $searchable = null
    )
    {
    }

    public function pointer(): ?PaginationCursorQueryParam
    {
        return $this->cursor;
    }

    public function limit(): LimitQueryParam
    {
        return $this->limit;
    }

    public function sort(): ?AbstractSortQueryParam
    {
        return $this->sortQueryParam;
    }

    public function filters(): ?FiltersQueryParam
    {
        return $this->filters;
    }

    public function searchable(): ?SearchableQueryParam
    {
        return $this->searchable;
    }

    public function toUrlString(PaginationCursorQueryParam $pointer = null): string
    {
        return $this->generateUrl(
            $this->filters,
            $this->searchable,
            is_null($pointer) ? $this->cursor : $pointer,
            $this->limit,
            $this->sortQueryParam
        );
    }

    private function generateUrl(
        ?FiltersQueryParam $filters,
        ?SearchableQueryParam $searchable,
        ?PaginationCursorQueryParam $pointer,
        LimitQueryParam $limit,
        ?AbstractSortQueryParam $sort
    ): string
    {
        $queryParams = $filters !== null ? '?' . $filters->__toString() : '';
        $queryParams .= $searchable !== null ? (empty($queryParams) ? '?' : '&') . $searchable->__toString() : '';
        $queryParams .= $pointer !== null ? (empty($queryParams) ? '?' : '&') . $pointer->__toString() : '';
        $queryParams .= $sort !== null ? (empty($queryParams) ? '?' : '&') . $sort->__toString() : '';
        $queryParams .= (empty($queryParams) ? '?' : '&') . $limit->__toString();

        return $queryParams;
    }

    public static function fromPrimitives(
        ?PaginationCursorQueryParam $pointer,
        int $limit,
        ?string $sort,
        ?array $filters,
        ?string $searchable
    ): self
    {
        $limitObj = new LimitQueryParam($limit);
        $sortObj = is_null($sort) ? null : new AbstractSortQueryParam($sort);
        $filtersObj = is_null($filters) ? null : FiltersQueryParam::fromArray($filters);
        $searchableObj = is_null($searchable) ? null : new SearchableQueryParam($searchable);
        return new self($pointer, $limitObj, $sortObj, $filtersObj, $searchableObj);
    }
}
