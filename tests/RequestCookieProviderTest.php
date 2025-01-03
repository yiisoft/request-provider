<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestCookieProvider;
use Yiisoft\RequestProvider\RequestProvider;

final class RequestCookieProviderTest extends TestCase
{
    public function testGet(): void
    {
        $requestCookieProvider = $this->createRequestCookieProvider(['test' => 'value']);

        $this->assertSame('value', $requestCookieProvider->get('test'));
    }

    public function testHas(): void
    {
        $requestCookieProvider = $this->createRequestCookieProvider(['test' => 'value']);

        $this->assertTrue($requestCookieProvider->has('test'));
        $this->assertFalse($requestCookieProvider->has('non-exist'));
    }

    public function testWithChangesInRequest(): void
    {
        $requestA = $this->createRequest(['test' => 'a']);
        $requestB = $this->createRequest(['test' => 'b', 'city' => 'Voronezh']);

        $requestProvider = new RequestProvider();
        $requestProvider->set($requestA);

        $requestCookieProvider = new RequestCookieProvider($requestProvider);

        $this->assertSame('a', $requestCookieProvider->get('test'));
        $this->assertFalse($requestCookieProvider->has('city'));

        $requestProvider->set($requestB);

        $this->assertSame('b', $requestCookieProvider->get('test'));
        $this->assertTrue($requestCookieProvider->has('city'));
    }

    private function createRequestCookieProvider(array $cookies = []): RequestCookieProvider
    {
        $request = $this->createRequest($cookies);

        $requestProvider = new RequestProvider();
        $requestProvider->set($request);

        return new RequestCookieProvider($requestProvider);
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
