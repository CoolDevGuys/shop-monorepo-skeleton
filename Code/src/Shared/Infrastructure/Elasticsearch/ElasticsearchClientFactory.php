<?php

declare(strict_types=1);

use Elasticsearch\ClientBuilder;

final class ElasticsearchClientFactory
{
    public static function createClient(string $host): ElasticsearchClient
    {
        $client = ClientBuilder::create()->setHosts([$host])->build();

        return new ElasticsearchClient($client);
    }
}
