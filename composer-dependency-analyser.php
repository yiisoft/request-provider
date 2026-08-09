<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

return (new Configuration())
    ->disableComposerAutoloadPathScan()
    ->setFileExtensions(['php'])
    ->addPathToScan(__DIR__ . '/config', isDev: false)
    ->addPathToScan(__DIR__ . '/src', isDev: false)
    ->addPathToScan(__DIR__ . '/tests', isDev: true)
    // config/events-web.php references yiisoft/middleware-dispatcher's event class purely as an optional
    // integration hook (array key); the package is not a real dependency of this provider.
    ->ignoreUnknownClasses(['Yiisoft\Middleware\Dispatcher\Event\BeforeMiddleware']);
