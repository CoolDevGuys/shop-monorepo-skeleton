<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface RandomNumberGenerator
{
    public function generate(): int;
}
