<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\Symfony;

use CoolDevGuys\Shared\Domain\Bus\Command\Command;
use CoolDevGuys\Shared\Domain\Bus\Command\CommandBus;
use CoolDevGuys\Shared\Domain\Bus\Query\Query;
use CoolDevGuys\Shared\Domain\Bus\Query\QueryBus;
use CoolDevGuys\Shared\Domain\Bus\Query\QueryResponse;
use function Lambdish\Phunctional\each;

abstract class ApiController
{
    private QueryBus                           $queryBus;
    private CommandBus                         $commandBus;

    public function __construct(
        QueryBus $queryBus,
        CommandBus $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;

        each(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    abstract protected function exceptions(): array;

    protected function ask(Query $query): ?QueryResponse
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
