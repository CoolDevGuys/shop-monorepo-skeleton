<?php

use CoolDevGuys\Applications\Shop\ShopKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

//(new Dotenv())->bootEnv(__DIR__ . '/../.env');
$kernel = new ShopKernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
return new Application($kernel);

