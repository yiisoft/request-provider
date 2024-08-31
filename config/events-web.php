<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Yiisoft\Middleware\Dispatcher\Event\BeforeMiddleware;
use Yiisoft\RequestProvider\RequestProvider;
use Yiisoft\RequestProvider\RequestProviderInterface;

/** @var array $params */

return [
    BeforeMiddleware::class => [
        static function (ContainerInterface $container, RequestProviderInterface $provider, BeforeMiddleware $event) {
            $provider->set($event->getRequest());
        },
    ],
];
