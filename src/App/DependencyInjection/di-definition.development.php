<?php

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use function DI\get;
use function DI\object;
use function DI\string;

return [
    /* Logger configuration */
    StreamHandler::class => object()->constructor(string('{dir.logs}/logs-dev.log')),
    RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger-dev.log'), get('maxLogFiles'))
];