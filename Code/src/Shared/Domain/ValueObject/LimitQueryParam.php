<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Errors\InvalidLimitQueryParamError;

final class LimitQueryParam extends IntValueObject
{
    public const LIMIT_LABEL = 'limit';

    public function __construct(int $value)
    {
        $this->guard($value);

        parent::__construct($value);
    }

    private function guard(int $value): void
    {
        if ($value < 0) {
            throw new InvalidLimitQueryParamError($value);
        }
    }

    public function __toString(): string
    {
        return self::LIMIT_LABEL . '=' . parent::__toString();
    }
}
