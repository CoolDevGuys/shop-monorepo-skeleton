<?php

declare(strict_types=1);

namespace CoolDevGuys\Applications\Dashboard\Frontend\Controller\Home;

use CoolDevGuys\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeGetWebController extends WebController
{
    protected function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request): Response
    {
        return $this->render(
            'pages/home.html.twig',
            [
                'title' => 'Welcome',
                'description' => 'CoolDevGuys - Dashboard',
            ]
        );
    }
}
