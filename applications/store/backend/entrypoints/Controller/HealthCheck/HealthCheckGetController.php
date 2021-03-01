<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Store\Backend\Controller\HealthCheck;

use CoolDevGuys\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class HealthCheckGetController
{
    private RandomNumberGenerator $generator;

    public function __construct(RandomNumberGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'store-backend' => 'ok',
                'rand'         => $this->generator->generate(),
            ]
        );
    }
}
