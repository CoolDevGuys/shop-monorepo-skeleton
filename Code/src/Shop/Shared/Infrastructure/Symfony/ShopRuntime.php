<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Shared\Infrastructure\Symfony;

use Symfony\Component\Runtime\SymfonyRuntime;

final class ShopRuntime extends SymfonyRuntime
{
    public function __construct(array $options = [])
    {
        $customOptions = ['disable_dotenv' => true];
        parent::__construct($options + $customOptions);
    }
}
