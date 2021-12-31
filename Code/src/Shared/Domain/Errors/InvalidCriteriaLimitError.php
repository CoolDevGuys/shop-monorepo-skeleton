<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class InvalidCriteriaLimitError extends DomainError
{
    public function __construct(private int $limit, private int $max)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_criteria_limit';
    }

    protected function errorMessage(): string
    {
        return sprintf('The provided limit value: %d is incorrect, the value should not be longer than %d',
            $this->limit, $this->max);
    }
}
