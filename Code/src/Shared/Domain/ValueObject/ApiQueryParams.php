<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

final class ApiQueryParams
{
    private CursorQueryParam $cursor;
    private LimitQueryParam $limit;
    private ?AbstractSortQueryParam $sort;
    private ?FiltersQueryParam $filters;
    private ?SearchableQueryParam $searchables;
    private ?CursorQueryParam $nextCursor;
    private ?CursorQueryParam $prevCursor;

    public function __construct(
        CursorQueryParam $cursor,
        LimitQueryParam $limit,
        ?AbstractSortQueryParam $sortQueryParam = null,
        ?FiltersQueryParam $filters = null,
        ?SearchableQueryParam $search = null,
        ?CursorQueryParam $nextCursor = null,
        ?CursorQueryParam $prevCursor = null
    ) {
        $this->cursor      = $cursor;
        $this->limit       = $limit;
        $this->sort        = $sortQueryParam;
        $this->filters     = $filters;
        $this->searchables = $search;
        $this->nextCursor  = $nextCursor;
        $this->prevCursor  = $prevCursor;
    }

    public function cursor(): CursorQueryParam
    {
        return $this->cursor;
    }

    public function limit(): LimitQueryParam
    {
        return $this->limit;
    }

    public function sort(): ?AbstractSortQueryParam
    {
        return $this->sort;
    }

    public function filters(): ?FiltersQueryParam
    {
        return $this->filters;
    }

    public function searchables(): ?SearchableQueryParam
    {
        return $this->searchables;
    }

    public function nextCursor(): ?CursorQueryParam
    {
        return $this->nextCursor;
    }

    public function prevCursor(): ?CursorQueryParam
    {
        if ($this->cursor->value() > 1) {
            $this->prevCursor = new CursorQueryParam($this->cursor->value() - 1);
            return $this->prevCursor;
        }
        return null;
    }

    public function setNextCursor(
        CursorQueryParam $next
    ): void {
        $this->nextCursor = new CursorQueryParam($next->value());
    }

    public function toUrlString(): string
    {
        return $this->generateUrl($this->filters, $this->searchables, $this->cursor, $this->limit, $this->sort);
    }

    public function nextUrlString(): ?string
    {
        if (null !== $this->nextCursor) {
            return $this->generateUrl($this->filters, $this->searchables, $this->nextCursor, $this->limit, $this->sort);
        }

        return null;
    }

    public function prevUrlString(): ?string
    {
        if (null !== $this->prevCursor()) {
            return $this->generateUrl($this->filters, $this->searchables, $this->prevCursor, $this->limit, $this->sort);
        }

        return null;
    }

    private function generateUrl(
        ?FiltersQueryParam $filters,
        ?SearchableQueryParam $searchable,
        ?CursorQueryParam $cursor,
        LimitQueryParam $limit,
        ?AbstractSortQueryParam $sort
    ): string {
        $queryParams = $filters !== null ? '?'.$filters->__toString() : '';
        $queryParams .= $searchable !== null ? (empty($queryParams) ? '?' : '&') . $searchable->__toString() : '';
        $queryParams .= $cursor !== null ? (empty($queryParams) ? '?' : '&') . $cursor->__toString() : '';
        $queryParams .= (empty($queryParams) ? '?' : '&') . $limit->__toString();
        $queryParams .= $sort !== null ? '?' . $sort->__toString() : '';

        return $queryParams;
    }
}
