<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;
use CoolDevGuys\Shared\Domain\JsonApiFormatter;
use CoolDevGuys\Shared\Domain\PaginatedByCriteriaCollection;
use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use CoolDevGuys\Shared\Domain\Response\ResponseData;
use CoolDevGuys\Shared\Domain\ValueObject\ApiQueryParams;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

final class SuccessfulJsonApiResponse implements JsonApiResponse
{
    public function __construct(
        private ResponseData $data,
        private int          $statusCode,
        private ?array       $links = null,
        private ?array       $meta = null
    )
    {
        $this->validateStatusCode($statusCode);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray(): ?array
    {
        if (null === $this->data->data()) {
            return null;
        }

        return [
            'links' => $this->links,
            'data' => $this->data->jsonApiSerialize(),
            'meta' => $this->meta
        ];
    }

    private function validateStatusCode(int $statusCode): void
    {
        if ($statusCode < Response::HTTP_OK || $statusCode >= Response::HTTP_MULTIPLE_CHOICES) {
            throw new  \RuntimeException(
                'The provided status code does not correspond to a successful HTTP status code'
            );
        }
    }

    public static function ok(ResponseData $data, array $links = null, array $meta = null): self
    {
        return new self($data, Response::HTTP_OK, $links, $meta);
    }

    public static function noContent(): self
    {
        return new self(new NullResponseData(), Response::HTTP_NO_CONTENT);
    }

    public static function created(): self
    {
        return new self(new NullResponseData(), Response::HTTP_CREATED);
    }

    public function okWithPagination(ResponseData $data, ): self {}

    public static function forPaginatedCollection(
        PaginatedByCriteriaCollection $paginatedCollection,
        ApiQueryParams                $queryParams, string $baseUrl
    ): self
    {
        $links = [
            'prev' => is_null($queryParams->prevUrlString()) ? null : $baseUrl . $queryParams->prevUrlString(),
            'next' => is_null($queryParams->nextUrlString()) ? null : $baseUrl . $queryParams->nextUrlString()
        ];

        $meta = [
            'page' => ['total' => $paginatedCollection->totalPages(), 'current' => $paginatedCollection->currentPage()],
            'count' => $paginatedCollection->total()
        ];

        return new self(
            map(fn(AggregateRoot $element) => JsonApiFormatter::formatEntity($element, $baseUrl),
                $paginatedCollection->data())
            ,
            Response::HTTP_OK,
            $links,
            $meta
        );
    }
}
