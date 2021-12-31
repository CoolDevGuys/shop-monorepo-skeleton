<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidFilterQueryParamError extends DomainError
{
    public function __construct(private mixed $value)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_filter_query_param';
    }

    protected function errorMessage(): string
    {
        return sprintf('The filter query param value: %s is invalid', $this->value);
    }
}
