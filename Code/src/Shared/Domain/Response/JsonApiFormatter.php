<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Response;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;
use CoolDevGuys\Shared\Domain\Collection;
use function Lambdish\Phunctional\map;

final class JsonApiFormatter
{
    public static function formatCollection(
        array|Collection     $collection,
        EntityPropertiesList $allowedProperties = null
    ): array
    {
        return map(fn(array|AggregateRoot $entity) => self::formatOne($entity, $allowedProperties), $collection);
    }

    public static function formatOne(array|AggregateRoot $entity, EntityPropertiesList $allowedProperties = null): array
    {
        $formattedEntity = [];
        $elementArray = $entity instanceof AggregateRoot ? $entity->toArray() : $entity;
        $formattedEntity['id'] = $elementArray['id'];
        unset($elementArray['id']);

        $attributes = $elementArray;
        if ($allowedProperties) {
            $attributes = self::removeNotAllowedProperties($elementArray, $allowedProperties);
        }
        $formattedEntity['attributes'] = $attributes;
        return $formattedEntity;
    }

    private static function removeNotAllowedProperties(
        array                $elementArray,
        EntityPropertiesList $allowedProperties
    ): array
    {
        $filteredProperties = [];
        foreach ($elementArray as $property => $value) {
            $isAllowedProperty = in_array($property, $allowedProperties->getProperties(), true);
            if ($isAllowedProperty) {
                $filteredProperties[$property] = $value;
            }
        }
        return $filteredProperties;
    }
}
