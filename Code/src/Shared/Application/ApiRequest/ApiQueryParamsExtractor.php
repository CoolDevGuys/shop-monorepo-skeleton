<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Application\ApiRequest;

use CoolDevGuys\Shared\Domain\ValueObject\ApiQueryParams;
use CoolDevGuys\Shared\Domain\ValueObject\CursorQueryParam;
use CoolDevGuys\Shared\Domain\ValueObject\FiltersQueryParam;
use CoolDevGuys\Shared\Domain\ValueObject\LimitQueryParam;
use CoolDevGuys\Shared\Domain\ValueObject\SearchableQueryParam;
use CoolDevGuys\Shared\Domain\ValueObject\AbstractSortQueryParam;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiQueryParamsExtractor
{
    private const DEFAULT_CURSOR = 1;
    private const DEFAULT_LIMIT  = 50;

    public static function getParameters(Request $request): ApiQueryParams
    {
        $cursor      = self::extractCursor($request);
        $limit       = self::extractLimit($request);
        $sort        = static::extractSort($request);
        $filters     = static::extractFilters($request);
        $searchables = self::extractSearch($request);

        return new ApiQueryParams($cursor, $limit, $sort, $filters, $searchables);
    }

    private static function extractCursor(Request $request): CursorQueryParam
    {
        $cursor = $request->query->get(CursorQueryParam::CURSOR_LABEL, null);
        if (!empty($cursor)) {
            return new CursorQueryParam((int)$cursor);
        }

        return new CursorQueryParam(self::DEFAULT_CURSOR);
    }

    private static function extractLimit(Request $request): LimitQueryParam
    {
        $limit = $request->query->get(LimitQueryParam::LIMIT_LABEL, null);
        if (!empty($limit)) {
            return new LimitQueryParam((int)$limit);
        }

        return new LimitQueryParam(self::DEFAULT_LIMIT);
    }

    abstract protected static function extractSort(Request $request): ?AbstractSortQueryParam;

    abstract protected static function extractFilters(Request $request): ?FiltersQueryParam;

    private static function extractSearch(Request $request): ?SearchableQueryParam
    {
        $search = $request->query->get(SearchableQueryParam::SEARCH_LABEL, null);
        if (!empty($search)) {
            return new SearchableQueryParam($search);
        }

        return null;
    }
}
