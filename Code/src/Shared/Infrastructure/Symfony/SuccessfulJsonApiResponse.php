<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use Symfony\Component\HttpFoundation\Response;

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

    private function validateStatusCode(int $statusCode): void
    {
        if ($statusCode < Response::HTTP_OK || $statusCode >= Response::HTTP_MULTIPLE_CHOICES) {
            throw new  \RuntimeException('The provided status code does not correspond to a successful HTTP status code');
        }
    }
}
