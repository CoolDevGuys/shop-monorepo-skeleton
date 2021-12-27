<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Request\RequestValidator;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

final class ApiRequestValidatorListener
{
    public function __construct(private RequestValidator $requestValidator)
    {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if (!$event->getController() instanceof ApiController) {
            return;
        }

        $this->requestValidator->validate($event->getRequest());
    }
}
