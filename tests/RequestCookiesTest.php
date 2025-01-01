<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestCookies;
use Yiisoft\RequestProvider\RequestProvider;
use Yiisoft\RequestProvider\RequestProviderInterface;

final class RequestCookiesTest extends TestCase
{
    public function testGet(): void
    {
        $requestCookies = $this->createRequestCookies(['test' => 'value']);

        $this->assertSame('value', $requestCookies->get('test'));
    }

    public function testHas(): void
    {
        $requestCookies = $this->createRequestCookies(['test' => 'value']);

        $this->assertTrue($requestCookies->has('test'));
        $this->assertFalse($requestCookies->has('non-exist'));
    }

    public function testWithChangesInRequest(): void
    {
        $requestA = $this->createRequest(['test' => 'a']);
        $requestB = $this->createRequest(['test' => 'b', 'city' => 'Voronezh']);

        $requestProvider = new RequestProvider();
        $requestProvider->set($requestA);

        $requestCookies = new RequestCookies($requestProvider);

        $this->assertSame('a', $requestCookies->get('test'));
        $this->assertFalse($requestCookies->has('city'));

        $requestProvider->set($requestB);

        $this->assertSame('b', $requestCookies->get('test'));
        $this->assertTrue($requestCookies->has('city'));
    }

    private function createRequestCookies(array $cookies = []): RequestCookies
    {
        $request = $this->createRequest($cookies);

        $requestProvider = new RequestProvider();
        $requestProvider->set($request);

        return new RequestCookies($requestProvider);
    }

    private function createRequest(array $cookies = []): ServerRequestInterface
    {
        /** @var ServerRequestInterface $request */
        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->method('getCookieParams')
            ->willReturn($cookies);

        return $request;
    }
}
