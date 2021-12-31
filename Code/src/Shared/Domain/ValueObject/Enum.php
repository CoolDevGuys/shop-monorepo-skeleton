<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Utils;
use CoolDevGuys\Shared\Domain\ValueObject;
use function Lambdish\Phunctional\reindex;

abstract class Enum implements ValueObject
{
    protected static array $cache = [];

    public function __construct(protected mixed $value)
    {
        $this->ensureIsBetweenAcceptedValues($value);
    }

    abstract protected function throwExceptionForInvalidValue(string $value): void;

    public static function __callStatic(string $name, mixed $args): static
    {
        return new static(self::values()[$name]);
    }

    public static function fromString(string $value): Enum
    {
        return new static($value);
    }

    public static function values(): array
    {
        $class = static::class;

        if (!isset(self::$cache[$class])) {
            $reflected = new \ReflectionClass($class);
            self::$cache[$class] = reindex(self::keysFormatter(), $reflected->getConstants());
        }

        return self::$cache[$class];
    }

    public static function randomValue(): mixed
    {
        return self::values()[array_rand(self::values())];
    }

    public static function random(): self
    {
        return new static(self::randomValue());
    }

    private static function keysFormatter(): callable
    {
        return static fn($unused, string $key): string => Utils::toCamelCase(strtolower($key));
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function equals(Enum $other): bool
    {
        return $other == $this;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    private function ensureIsBetweenAcceptedValues(mixed $value): void
    {
        if (!in_array((string)$value, static::values(), true)) {
            $this->throwExceptionForInvalidValue((string)$value);
        }
    }
}
