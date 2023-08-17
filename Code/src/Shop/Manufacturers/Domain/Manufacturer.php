<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Manufacturers\Domain;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;

class Manufacturer extends AggregateRoot
{

    public function toJsonApiResponseArray(string $baseUrl): array
    {
        // TODO: Implement toJsonApiResponseArray() method.
    }

    public function toArray(): array
    {
        return [];
    }

    public function entityType(): string
    {
        return '';
    }
}
