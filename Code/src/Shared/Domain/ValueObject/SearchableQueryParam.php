<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject;

final class SearchableQueryParam extends StringValueObject
{
    public const SEARCH_LABEL = 'q';

    public function __toString(): string
    {
        return self::SEARCH_LABEL . '=' . urlencode(parent::__toString());
    }
}
