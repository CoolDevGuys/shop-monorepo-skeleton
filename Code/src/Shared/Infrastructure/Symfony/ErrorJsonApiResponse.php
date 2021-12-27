<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\DomainError;
use CoolDevGuys\Shared\Domain\Response\JsonApiResponse;
use CoolDevGuys\Shared\Domain\Utils;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ErrorJsonApiResponse implements JsonApiResponse
{
    public function __construct(private string $title, private int $status, private string $code,
        private string $detail, private ?array $meta = null)
    {
        $this->validateStatusCode($this->status);
    }

    public function addMetaInformation(array $meta): void
    {
        $this->meta = $meta;
    }

    public function toArray(): array
    {
        $error = [
            'title' => $this->title,
            'status' => $this->status,
            'code' => $this->code,
            'detail' => $this->detail,
        ];

        if (null !== $this->meta) {
            $error['meta'] = $this->meta;
        }
        return $error;
    }

    public function statusCode(): int
    {
        return $this->status;
    }

    private function validateStatusCode(int $status): void
    {
        if ($status < Response::HTTP_BAD_REQUEST || $status > Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED) {
            throw new \RuntimeException('The provided status code does not correspond to an error HTTP code');
        }
    }

    private static function extractTitle(Throwable $exception): string
    {
        return Utils::splitWords(Utils::extractClassName($exception));
    }

    private static function exceptionCodeFor(Throwable $exception): string
    {
        $code = $exception instanceof DomainError ? $exception->errorCode() : $exception->getCode();
        return sprintf('ERR::%s', $code);
    }

    public static function fromException(Throwable $exception, int $statusCode, ?array $meta = null): self
    {
        return new self(self::extractTitle($exception), $statusCode,
            self::exceptionCodeFor($exception), $exception->getMessage(), $meta);
    }
}
