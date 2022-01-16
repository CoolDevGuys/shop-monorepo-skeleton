<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;
use CoolDevGuys\Shared\Domain\PaginatedByCriteriaCollection;
use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use CoolDevGuys\Shared\Domain\ValueObject\ApiQueryParams;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

final class SuccessfulJsonApiResponse implements JsonApiResponse
{
    public function __construct(private array $data, private int $statusCode, private ?array $links = null,
        private ?array $meta = null)
    {
        $this->validateStatusCode($statusCode);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray(): array
    {
        return [
            'links' => $this->links,
            'data' => $this->data,
            'meta' => $this->meta
        ];
    }

    public static function forPaginatedCollection(PaginatedByCriteriaCollection $paginatedCollection,
        ApiQueryParams $queryParams, string $baseUrl): self
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
            map(function (AggregateRoot $element) use ($baseUrl) {
                return $element->toJsonApiResponseArray($baseUrl);
            }, $paginatedCollection->data())
            ,
            Response::HTTP_OK,
            $links,
            $meta
        );
    }

    private function validateStatusCode(int $statusCode): void
    {
        if ($statusCode < Response::HTTP_OK || $statusCode >= Response::HTTP_MULTIPLE_CHOICES) {
            throw new  \RuntimeException('The provided status code does not correspond to a successful HTTP status code');
        }
    }
}
