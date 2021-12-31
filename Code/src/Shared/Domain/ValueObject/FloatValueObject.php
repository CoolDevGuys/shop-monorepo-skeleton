<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject;

abstract class FloatValueObject implements ValueObject
{
    public function __construct(protected float $value)
    {
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
