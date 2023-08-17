<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

final class ProductMetadata
{
    public function __construct(private readonly string $material,) {

    }
}
