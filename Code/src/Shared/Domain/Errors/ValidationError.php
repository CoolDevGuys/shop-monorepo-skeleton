<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class ValidationError extends DomainError
{
    public function __construct(private string $detail)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'validation_error';
    }

    protected function errorMessage(): string
    {
        return sprintf('Validation error: %s', $this->detail);
    }
}
