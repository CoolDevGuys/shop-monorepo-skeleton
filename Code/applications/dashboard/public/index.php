<?php

use CoolDevGuys\Applications\Dashboard\DashboardKernel;

require dirname(__DIR__) . '/../../vendor/autoload_runtime.php';

return function (array $context) {
    return new DashboardKernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
};
