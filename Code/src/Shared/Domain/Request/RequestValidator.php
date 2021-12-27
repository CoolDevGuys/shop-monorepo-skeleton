<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Request;

use CoolDevGuys\Shared\Domain\Errors\ValidationError;
use Symfony\Component\HttpFoundation\Request;

interface RequestValidator
{
    /** @throws ValidationError */
    public function validate(Request $request): void;
}
