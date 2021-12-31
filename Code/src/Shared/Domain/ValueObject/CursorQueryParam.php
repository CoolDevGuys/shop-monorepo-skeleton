<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Errors\InvalidCursorQueryParamError;

final class CursorQueryParam extends IntValueObject
{
    public const CURSOR_LABEL = 'cursor';

    public function __construct(int $value)
    {
        $this->guard($value);

        parent::__construct($value);
    }

    private function guard(int $value): void
    {
        if ($value < 0) {
            throw new InvalidCursorQueryParamError($value);
        }
    }

    public function __toString(): string
    {
        return self::CURSOR_LABEL . '=' . parent::__toString();
    }
}
