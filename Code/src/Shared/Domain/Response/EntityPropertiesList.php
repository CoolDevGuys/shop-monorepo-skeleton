<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Response;

interface EntityPropertiesList
{
    public function getProperties(): array;

    public function addProperty(string $propertyName): void;
}
