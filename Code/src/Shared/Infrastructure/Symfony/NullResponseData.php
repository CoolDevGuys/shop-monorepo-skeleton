<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;


use CoolDevGuys\Shared\Domain\Response\ResponseData;

final class NullResponseData implements ResponseData
{
    public function __construct()
    {
    }

    public function data(): ?array
    {
        return null;
    }

    public function jsonApiSerialize(): ?array
    {
        return null;
    }
}
