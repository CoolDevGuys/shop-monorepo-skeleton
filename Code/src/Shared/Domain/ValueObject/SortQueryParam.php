<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

final class SortQueryParam extends AbstractSortQueryParam
{

    public static function fromString(string $value): AbstractSortQueryParam
    {
        [$value, $order] = self::decomposeSortValue($value);
    }

    public function getSupportedSortAttributes(): array
    {
        // TODO: Implement getSupportedSortAttributes() method.
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    private static function decomposeSortValue(string $value): array
    {
        $firstCharacter = $value[0];

        $order = $this->getOrder($firstCharacter);

        $cleanedSortLabel = $this->getCleanedSortLabel($firstCharacter, $value);

        return [$cleanedSortLabel, $order];
    }

    protected function getOrder(string $firstCharacter): string
    {
        return $firstCharacter === '-'
            ? self::DESC
            : self::ASC;
    }

    protected function getCleanedSortLabel(string $firstCharacter, string $value): string
    {
        // if the $firstCharacter starts with '-' or '+', return $value without the sign
        // else (when no sign) return directly the $value
        return in_array($firstCharacter, ['+', '-'])
            ? substr($value, 1)
            : $value;
    }
}
