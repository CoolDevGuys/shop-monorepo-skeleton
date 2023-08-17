<?php
declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Response;

interface ResponseData
{
    public function data(): ?array;

    public function jsonApiSerialize(): ?array;
}
