<?php

use CoolDevGuys\Applications\Dashboard\DashboardKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

//(new Dotenv())->bootEnv(__DIR__ . '/../.env');
$kernel = new DashboardKernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
return new Application($kernel);
