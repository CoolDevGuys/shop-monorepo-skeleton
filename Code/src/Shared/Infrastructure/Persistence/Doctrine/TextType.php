<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine;

use CoolDevGuys\Shared\Domain\Utils;
use CoolDevGuys\Shared\Domain\ValueObject\StringValueObject;
use CoolDevGuys\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use function Lambdish\Phunctional\last;

abstract class TextType extends StringType implements DoctrineCustomType
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


    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var StringValueObject $value */
        return $value->value();
    }
}
