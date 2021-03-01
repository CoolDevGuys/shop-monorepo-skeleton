<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure;

use CoolDevGuys\Shared\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
