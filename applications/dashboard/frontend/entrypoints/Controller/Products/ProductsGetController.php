<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Dashboard\Frontend\Controller\Products;

use CoolDevGuys\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

final class ProductsGetController extends WebController
{
    public function __invoke(): Response
    {

    }

    protected function exceptions(): array
    {
        return [];
    }
}
