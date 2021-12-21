<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Shop\Controller\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class HealthCheckGetController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'dashboard' => 'ok',
            ]
        );
    }
}
