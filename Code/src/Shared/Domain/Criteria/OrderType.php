<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Criteria;

final class OrderType extends Enum
{
    public const ASC  = 'asc';
    public const DESC = 'desc';
    public const NONE = 'none';

    public function isNone(): bool
    {
        return $this->equals(self::none());
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new \InvalidArgumentException($value);
    }
}
