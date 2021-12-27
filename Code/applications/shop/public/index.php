<?php

use CoolDevGuys\Applications\Shop\ShopKernel;

require dirname(__DIR__) . '/../../vendor/autoload_runtime.php';

return function (array $context) {
    return new ShopKernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
};
