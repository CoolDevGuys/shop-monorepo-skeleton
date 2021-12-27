<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Shop\Controller\HealthCheck;

use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use CoolDevGuys\Shared\Infrastructure\Symfony\SuccessfulJsonApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckGetController
{
    public function __invoke(Request $request): JsonApiResponse
    {
        return new SuccessfulJsonApiResponse(['status' => 'ok'], Response::HTTP_OK);
    }
}
