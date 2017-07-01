<?php
/**
 * Configuration file.
 */

use function DI\string;
use function DI\env;

return [
    'dir.base' => __DIR__ . '/..',
    'dir.cache' => string('{dir.base}/cache'),
    'dir.config' => string('{dir.base}/config'),
    'dir.docs' => string('{dir.base}/docs'),
    'dir.logs' => string('{dir.base}/logs'),
    'dir.src' => string('{dir.base}/src'),
    'dir.src.entities' => string('{dir.src}/Model/Entity'),
    'dir.storage' => string('{dir.base}/storage'),

    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => false,
];
