<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Elasticsearch;

use Elasticsearch\ClientBuilder;

final class ElasticsearchClientFactory
{
    public static function createClient(string $host): ElasticsearchClient
    {
        $client = ClientBuilder::create()->setHosts([$host])->build();

        return new ElasticsearchClient($client);
    }
}
