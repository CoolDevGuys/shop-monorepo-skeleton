<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Errors\InvalidFilterQueryParamError;
use CoolDevGuys\Shared\Domain\ValueObject;

abstract class FilterQueryParam implements ValueObject
{
    public function __construct(private string $filterLabel, private mixed $value)
    {
        $this->guard($filterLabel);
    }

    public function filterLabel(): string
    {
        return $this->filterLabel;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    private function guard(string $filterLabel): void
    {
        if (!in_array($filterLabel, static::getAvailableFilters(), true)) {
            throw new InvalidFilterQueryParamError($filterLabel);
        }
    }

    public function __toString(): string
    {
        return sprintf('%s=%s', $this->filterLabel, urlencode((string)$this->value));
    }

    public function toArray(): array
    {
        return [$this->filterLabel(), $this->value()];
    }

    /** Expects an array [$label, $value, ?$valueForPagination] */
    public static function fromArray(array $filter): self
    {
        if (count($filter) !== 2) {
            throw new \RuntimeException('The filter array has the wrong amount of elements, expected 2');
        }
        return new static($filter[0], $filter[1]);
    }

    abstract public static function getAvailableFilters(): array;
}
