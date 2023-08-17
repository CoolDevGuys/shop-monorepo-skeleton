<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

final readonly class PaginationCursorQueryParam implements FilterQueryParam
{
    public function __construct(private string $value) {}

    public function filterLabel(): string
    {
        return 'cursor';
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return ['cursor' => $this->value];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
