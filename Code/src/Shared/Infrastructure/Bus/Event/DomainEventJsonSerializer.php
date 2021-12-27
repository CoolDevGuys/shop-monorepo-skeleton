<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Bus\Event;

use CoolDevGuys\Shared\Domain\Bus\Event\DomainEvent;

final class DomainEventJsonSerializer
{
    public static function serialize(DomainEvent $domainEvent): string
    {
        return (string)json_encode([
            'data' => [
                'id' => $domainEvent->eventId(),
                'type' => $domainEvent::eventName(),
                'occurred_at' => $domainEvent->occurredOn(),
                'attributes' => array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->aggregateId()]),
            ],
            'meta' => [],
        ], JSON_THROW_ON_ERROR);
    }
}
