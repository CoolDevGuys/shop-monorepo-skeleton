<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Errors;

use CoolDevGuys\Shared\Domain\DomainError;

final class EnvVariableNotFoundError extends DomainError
{
    public function __construct(private string $variable)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'env_variable_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The environment variable %s has not been set', $this->variable);
    }
}
