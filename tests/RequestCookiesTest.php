<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestProvider;

final class RequestCookiesTest extends TestCase
{
    public function testGet(): void
    {
        $cookies = ['test' => 'value'];
        $request = $this->createRequestProvider($cookies)->get();
        $cookiesFromRequest = $request->getCookieParams();

        $this->assertSame($cookies, $cookiesFromRequest);
    }

    public function testHas(): void
    {
        $cookies = ['test' => 'value'];
        $request = $this->createRequestProvider($cookies)->get();
        $cookiesFromRequest = $request->getCookieParams();

        $this->assertArrayHasKey('test', $cookiesFromRequest);
        $this->assertArrayNotHasKey('non-exist', $cookiesFromRequest);
    }

    public function testWithChangesInRequest(): void
    {
        $requestA = $this->createRequest(['test' => 'a']);
        $requestB = $this->createRequest(['test' => 'b', 'city' => 'Voronezh']);

        $requestProvider = new RequestProvider();
        $requestProvider->set($requestA);

        $requestACookies = $requestProvider->get()->getCookieParams();

        $this->assertSame('a', $requestACookies['test']);
        $this->assertArrayNotHasKey('city', $requestACookies);

        $requestProvider->set($requestB);
        $requestBCookies = $requestProvider->get()->getCookieParams();

        $this->assertSame('b', $requestBCookies['test']);
        $this->assertArrayHasKey('city', $requestBCookies);
    }

    private function createRequestProvider(array $cookies = []): RequestProvider
    {
        $request = $this->createRequest($cookies);

        $requestProvider = new RequestProvider();
        $requestProvider->set($request);

        return $requestProvider;
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
