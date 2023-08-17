<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

interface FilterQueryParam
{
    public function filterLabel(): string;

    public function value(): mixed;

    public function toArray(): array;

    public function __toString(): string;
}
