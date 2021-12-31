<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine;

use CoolDevGuys\Shared\Domain\Utils;
use CoolDevGuys\Shared\Domain\ValueObject\DateValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use function Lambdish\Phunctional\last;

abstract class DateTimeType extends \Doctrine\DBAL\Types\DateTimeType implements \Stringable
{
    abstract protected function typeClassName(): string;

    public function getName(): string
    {
        return self::customTypeName();
    }

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', last(explode('\\', static::class))));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform): \DateTime
    {
        /** @var DateValueObject $value */
        return $value->value();
    }
}
