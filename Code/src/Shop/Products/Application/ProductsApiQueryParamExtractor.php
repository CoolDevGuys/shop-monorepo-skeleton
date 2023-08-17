<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Application;

use CoolDevGuys\Shared\Application\ApiRequest\ApiQueryParamsExtractor;
use CoolDevGuys\Shared\Domain\ValueObject\FiltersQueryParam;
use CoolDevGuys\Shared\Domain\ValueObject\AbstractSortQueryParam;
use CoolDevGuys\Shop\Products\Domain\ValueObject\ProductsFilterQueryParam;
use CoolDevGuys\Shop\Products\Domain\ValueObject\ProductsAbstractSortQueryParam;
use Symfony\Component\HttpFoundation\Request;

final class ProductsApiQueryParamExtractor extends ApiQueryParamsExtractor
{
    protected static function extractSort(Request $request): ?AbstractSortQueryParam
    {
        $sort = $request->query->get(AbstractSortQueryParam::SORT_LABEL, null);
        if (!empty($sort)) {
            return new ProductsAbstractSortQueryParam($sort);
        }

        return null;
    }

    protected static function extractFilters(Request $request): ?FiltersQueryParam
    {
        $filters = [];

        foreach (ProductsFilterQueryParam::getAvailableFilters() as $filterLabel) {
            $filter = $request->query->get($filterLabel);
            if (!empty($filter)) {
                $filters[] = new ProductsFilterQueryParam($filterLabel, $filter);
            }
        }

        if (!empty($filters)) {
            return new FiltersQueryParam($filters);
        }

        return null;
    }
}
