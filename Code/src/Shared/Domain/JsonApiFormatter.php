<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;

final class JsonApiFormatter
{
    public static function formatEntity(AggregateRoot $entity, string $baseUrl): array
    {
        $attr = $entity->toArray();
        $id = $attr['id'] ?? null;
        if (array_key_exists('id', $attr)) {
            unset($attr['id']);
        }
        return [
            'id' => $id,
            'type' => $entity->entityType(),
            'attributes' => $attr,
            'links' => ['self' => $baseUrl . '/' . $id]
        ];
    }
}
