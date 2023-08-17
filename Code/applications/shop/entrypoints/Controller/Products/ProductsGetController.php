<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Shop\Controller\Products;

use CoolDevGuys\Shared\Infrastructure\Symfony\ApiController;
use CoolDevGuys\Shared\Infrastructure\Symfony\SuccessfulJsonApiResponse;
use CoolDevGuys\Shop\Products\Application\Find\AllProductsPaginatedQuery;
use CoolDevGuys\Shop\Products\Application\Find\AllProductsPaginatedResponse;
use CoolDevGuys\Shop\Products\Application\ProductsApiQueryParamExtractor;
use Symfony\Component\HttpFoundation\Request;

final class ProductsGetController extends ApiController
{
    public function __invoke(Request $request): SuccessfulJsonApiResponse
    {
        $queryParams = ProductsApiQueryParamExtractor::getParameters($request);
        $query = new AllProductsPaginatedQuery($queryParams->limit()->value(), $queryParams->cursor()->value(),
            $queryParams->searchables()?->value());
        /** @var AllProductsPaginatedResponse $response */
        $response = $this->ask($query);
        $productsPaginated = $response->products();

        $baseUrl = $request->getPathInfo();

        return SuccessfulJsonApiResponse::ok($productsPaginated, $queryParams, $baseUrl);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
