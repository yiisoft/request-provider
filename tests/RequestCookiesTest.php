<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestCookies;
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

    private function createRequestCookies(array $cookies = []): RequestCookies
    {
        /** @var ServerRequestInterface $serverRequestMock */
        $serverRequestMock = $this->createMock(ServerRequestInterface::class);
        $serverRequestMock
            ->method('getCookieParams')
            ->willReturn($cookies);

        /** @var RequestProviderInterface $requestProvider */
        $requestProvider = $this->createMock(RequestProviderInterface::class);
        $requestProvider->method('get')->willReturn($serverRequestMock);

        return new RequestCookies($requestProvider);
    }
}
