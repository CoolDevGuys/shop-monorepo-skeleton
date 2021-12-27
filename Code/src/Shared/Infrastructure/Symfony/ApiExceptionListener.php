<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class ApiExceptionListener
{

    public function __construct(private ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $errorResponse = ErrorJsonApiResponse::fromException($exception, $this->extractStatusCode($exception));

        if (getenv('APP_DEBUG') === '1') {
            $errorResponse->addMetaInformation([
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => explode("\n", $exception->getTraceAsString()),
            ]);
        }

        $event->setResponse(
            new JsonResponse(
                $errorResponse->toArray(),
                $errorResponse->statusCode()
            )
        );
    }

    private function extractStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        return $this->exceptionHandler->statusCodeFor(get_class($exception));
    }
}
