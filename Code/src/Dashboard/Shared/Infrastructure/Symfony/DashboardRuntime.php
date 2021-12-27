<?php

declare(strict_types=1);

namespace CoolDevGuys\Dashboard\Shared\Infrastructure\Symfony;

use Symfony\Component\Runtime\SymfonyRuntime;

final class DashboardRuntime extends SymfonyRuntime
{
    public function __construct(array $options = [])
    {
        $customOptions = ['disable_dotenv' => true];
        parent::__construct($options + $customOptions);
    }
}
