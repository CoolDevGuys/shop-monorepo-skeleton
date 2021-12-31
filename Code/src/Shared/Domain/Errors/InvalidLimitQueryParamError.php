<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidLimitQueryParamError extends DomainError
{
    public function __construct(private int $limit)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_limit_query_param';
    }

    protected function errorMessage(): string
    {
        return sprintf('The provided limit query param: %d', $this->limit);
    }
}
