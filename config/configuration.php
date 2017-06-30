<?php
/**
 * Configuration file.
 */

use function DI\string;
use function DI\env;

return [
    'dir.base' => __DIR__ . '/../..',
    'dir.cache' => string('{app.baseDir}/cache'),
    'dir.config' => string('{app.baseDir}/config'),
    'dir.docs' => string('{app.baseDir}/docs'),
    'dir.logs' => string('{app.baseDir}/logs'),
    'dir.src' => string('{app.baseDir}/src'),
    'dir.storage' => string('{app.baseDir}/storage'),
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => false,
    'database.dsn' => env('DATABASE_DSN'),
    'database.user' => env('DATABASE_USER'),
    'database.pass' => env('DATABASE_PASSWORD')
];
