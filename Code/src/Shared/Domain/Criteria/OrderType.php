<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Criteria;

use CoolDevGuys\Shared\Domain\ValueObject\Enum;

/**
 * @method static OrderType asc()
 * @method static OrderType desc()
 * @method static OrderType none()
 */
final class OrderType extends Enum
{
    public const ASC  = 'asc';
    public const DESC = 'desc';
    public const NONE = 'none';

    public function isNone(): bool
    {
        return $this->equals(self::none());
    }

    protected function throwExceptionForInvalidValue(string $value): void
    {
        throw new \InvalidArgumentException($value);
    }
}
