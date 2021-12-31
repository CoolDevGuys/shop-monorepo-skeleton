<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Elasticsearch;

use Elasticsearch\Client;

final class ElasticsearchClient
{
    public function __construct(private Client $client)
    {
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function search(array $params): callable|array
    {
        return $this->client->search($params);
    }

    public function scroll(string $scroll, string $scrollId): callable|array
    {
        return $this->client->scroll([
            'scroll' => $scroll,
            'body' => [
                'scroll_id' => $scrollId
            ]
        ]);
    }

    public function count(array $params): int
    {
        $result = $this->client->count($params);
        return $result['count'];
    }
}
