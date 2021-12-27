<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
