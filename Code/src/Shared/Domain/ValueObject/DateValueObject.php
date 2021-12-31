<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\ValueObject;

final class DateValueObject implements ValueObject
{
    private const FORMAT = 'Y-m-d H:i:s';

    private \DateTime $value;

    public function __construct(string $date)
    {
        $formattedDate = \DateTime::createFromFormat(self::FORMAT, $date);
        if (!$formattedDate) {
            throw new \RuntimeException('Invalid date: ' . $date);
        }
        $this->value = $formattedDate;
    }

    public function value(): \DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format(self::FORMAT);
    }

    public static function now(): self
    {
        return new self(date(self::FORMAT));
    }
}
