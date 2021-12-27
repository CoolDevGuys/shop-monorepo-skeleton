<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\Bus\Query;


final class QueryNotRegisteredError extends \RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = get_class($query);

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
