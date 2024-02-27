<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\RequestProvider\RequestCatcherMiddleware;
use Yiisoft\RequestProvider\RequestProvider;

final class RequestCatcherMiddlewareTest extends TestCase
{
    public function testBase(): void
    {
        $requestProvider = new RequestProvider();
        $middleware = new RequestCatcherMiddleware($requestProvider);
        $request = $this->createMock(ServerRequestInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);

        $middleware->process($request, $handler);

        $this->assertSame($request, $requestProvider->get());
    }
}
