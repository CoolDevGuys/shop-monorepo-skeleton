<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;

final class ParseJsonApiResponseListener
{
    public function onKernelView(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        if (!$controllerResult instanceof JsonApiResponse) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                $controllerResult->toArray(),
                $controllerResult->statusCode()
            )
        );
    }
}
