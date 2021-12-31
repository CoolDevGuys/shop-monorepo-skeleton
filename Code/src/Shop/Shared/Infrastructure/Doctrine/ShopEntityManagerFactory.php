<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Shared\Infrastructure\Doctrine;

use CoolDevGuys\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

final class ShopEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../etc/databases/shop.sql';

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Shop', 'CoolDevGuys\Shop'),
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Dashboard', 'CoolDevGuys\Dashboard')
        );

        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../Shop', 'Shop');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            self::SCHEMA_PATH,
            $dbalCustomTypesClasses
        );
    }
}
