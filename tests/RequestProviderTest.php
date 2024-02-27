<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestNotSetException;
use Yiisoft\RequestProvider\RequestProvider;

final class RequestProviderTest extends TestCase
{
    public function testBase(): void
    {
        $requestProvider = new RequestProvider();
        $request = $this->createMock(ServerRequestInterface::class);

        $requestProvider->set($request);

        $this->assertSame($request, $requestProvider->get());
    }

    public function testRequestNotSet(): void
    {
        $requestProvider = new RequestProvider();

        $this->expectException(RequestNotSetException::class);
        $this->expectExceptionMessage('Request is not set.');
        $requestProvider->get();
    }
}
