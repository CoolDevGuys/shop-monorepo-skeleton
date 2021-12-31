<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidSortQueryParamError extends DomainError
{
    public function __construct(private string $value)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_sort_query_param';
    }

    protected function errorMessage(): string
    {
        return sprintf('The provided sort query param value: %d is invalid', $this->value);
    }
}
