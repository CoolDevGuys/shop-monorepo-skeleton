<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

interface ValueObject
{
    public function value(): mixed;

    public function __toString(): string;
}
