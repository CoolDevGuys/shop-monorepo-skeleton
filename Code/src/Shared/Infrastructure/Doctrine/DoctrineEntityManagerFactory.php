<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Doctrine;

use CoolDevGuys\Shared\Infrastructure\Doctrine\Dbal\DbalCustomTypesRegistrar;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Tools\Setup;
use function Lambdish\Phunctional\dissoc;

final class DoctrineEntityManagerFactory
{
    private static array $sharedPrefixes = [
        __DIR__ . '/../../../Shared/Infrastructure/Persistence/Mappings' => 'CoolDevGuys\Shared\Domain',
    ];

    public static function create(
        array $parameters,
        array $contextPrefixes,
        bool $isDevMode,
        string $schemaFile,
        array $dbalCustomTypesClasses
    ): EntityManager {
        if ($isDevMode) {
            static::generateDatabaseIfNotExists($parameters, $schemaFile);
        }

        DbalCustomTypesRegistrar::register($dbalCustomTypesClasses);

        return EntityManager::create($parameters, self::createConfiguration($contextPrefixes, $isDevMode));
    }

    private static function generateDatabaseIfNotExists(array $parameters, string $schemaFile): void
    {
        self::ensureSchemaFileExists($schemaFile);

        $databaseName = $parameters['dbname'];
        $parametersWithoutDatabaseName = dissoc($parameters, 'dbname');
        $connection = DriverManager::getConnection($parametersWithoutDatabaseName);
        $schemaManager = new MySqlSchemaManager($connection);

        if (!self::databaseExists($databaseName, $schemaManager)) {
            $schemaManager->createDatabase($databaseName);
            $connection->executeStatement(sprintf('USE %s', $databaseName));
            $schema = realpath($schemaFile);
            if (is_bool($schema)) {
                throw new \RuntimeException('Database schema file missing');
            }
            $schemaContent = file_get_contents($schema);
            if (empty($schemaContent)) {
                throw new \RuntimeException('Database schema file empty');
            }
            $connection->executeStatement($schemaContent);
        }

        $connection->close();
    }

    private static function databaseExists(string $databaseName, MySqlSchemaManager $schemaManager): bool
    {
        return in_array($databaseName, $schemaManager->listDatabases(), true);
    }

    private static function ensureSchemaFileExists(string $schemaFile): void
    {
        if (!file_exists($schemaFile)) {
            throw new \RuntimeException(sprintf('The file <%s> does not exist', $schemaFile));
        }
    }

    private static function createConfiguration(array $contextPrefixes, bool $isDevMode): Configuration
    {
        $queryCache = new \Symfony\Component\Cache\Adapter\PhpFilesAdapter('doctrine_queries');
        $config = Setup::createConfiguration($isDevMode, null);
        $config->setQueryCache($queryCache);

        $config->setMetadataDriverImpl(new SimplifiedXmlDriver(array_merge(self::$sharedPrefixes, $contextPrefixes)));

        return $config;
    }
}
