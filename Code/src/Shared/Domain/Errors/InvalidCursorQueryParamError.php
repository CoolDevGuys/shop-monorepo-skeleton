<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidCursorQueryParamError extends DomainError
{
    public function __construct(private int $cursor)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_cursor_query_param';
    }

    protected function errorMessage(): string
    {
        return sprintf('The provided cursor value: %d is invalid', $this->cursor);
    }
}
