<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Response;

interface JsonApiResponse
{
    public function toArray(): ?array;

    public function statusCode(): int;
}
