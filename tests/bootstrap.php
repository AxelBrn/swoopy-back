<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

passthru(sprintf(
    'php "%s/../bin/console" --env=test doctrine:database:drop --force',
    __DIR__
));
passthru(sprintf(
  'php "%s/../bin/console" --env=test doctrine:database:create',
  __DIR__
));
passthru(sprintf(
    'php "%s/../bin/console" --env=test doctrine:schema:create',
    __DIR__
));
passthru(sprintf(
    'php "%s/../bin/console" --env=test doctrine:fixtures:load --append',
    __DIR__
));
