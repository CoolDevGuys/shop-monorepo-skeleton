<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Errors\InvalidSortQueryParamError;
use CoolDevGuys\Shared\Domain\ValueObject;

abstract class SortQueryParam implements ValueObject
{
    private const ASC        = 'asc';
    private const DESC       = 'desc';
    public const  SORT_LABEL = 'sort';

    private string $value;
    private string $order;

    public function __construct(string $value)
    {
        [$cleanedValue, $this->order] = $this->decomposeSortValue($value);

        $this->guard($cleanedValue);

        $this->value = $this->supportedSortValuesMapping()[$cleanedValue];
    }

    private function guard(string $value): void
    {
        if (!array_key_exists($value, $this->supportedSortValuesMapping())) {
            throw new InvalidSortQueryParamError($value);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function order(): string
    {
        return $this->order;
    }

    public function __toString(): string
    {
        $inverseMapping = array_flip($this->supportedSortValuesMapping());
        $value          = $inverseMapping[$this->value] . $this->order === self::DESC ? '-' : '';

        return self::SORT_LABEL . '=' . urldecode($value);
    }

    private function decomposeSortValue(string $value): array
    {
        $firstCharacter = $value[0];

        $order = $this->getOrder($firstCharacter);

        $cleanedSortLabel = $this->getCleanedSortLabel($firstCharacter, $value);

        return [$cleanedSortLabel, $order];
    }

    private function getOrder(string $firstCharacter): string
    {
        return $firstCharacter === '-'
            ? self::DESC
            : self::ASC;
    }

    private function getCleanedSortLabel(string $firstCharacter, string $value): string
    {
        // if the $firstCharacter starts with '-' or '+', return $value without the sign
        // else (when no sign) return directly the $value
        return in_array($firstCharacter, ['+', '-'])
            ? substr($value, 1)
            : $value;
    }

    abstract protected function supportedSortValuesMapping(): array;
}
