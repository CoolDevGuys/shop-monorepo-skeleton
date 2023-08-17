<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Errors\InvalidSortQueryParamError;
use CoolDevGuys\Shared\Domain\ValueObject;

abstract class AbstractSortQueryParam implements ValueObject
{
    protected const ASC = 'asc';
    protected const DESC = 'desc';

    protected string $value;

    public function __construct(string $value, readonly protected string $order)
    {
        $this->guard($value);
        $this->value = $value;
    }

    abstract public static function fromString(string $value): self;

    abstract public function getSupportedSortAttributes(): array;

    protected function guard(string $value): void
    {
        if (!in_array($value, $this->getSupportedSortAttributes(), true)) {
            throw new InvalidSortQueryParamError($value);
        }
    }

    public function order(): string
    {
        return $this->order;
    }

    public function value(): string
    {
        // TODO: Implement value() method.
    }
}
