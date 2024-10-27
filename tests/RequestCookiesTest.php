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
        $requestCoockie = $this->getRequestCookies();

        $this->assertSame('value', $requestCoockie->get('test'));
    }

    public function testHas(): void
    {
        $requestCoockie = $this->getRequestCookies();

        $this->assertTrue($requestCoockie->has('test'));

        $this->assertFalse($requestCoockie->has('value'));
    }

    private function getRequestCookies(): RequestCookies
    {
        /** @var ServerRequestInterface $serverRequestMock */
        $serverRequestMock = $this->createMock(ServerRequestInterface::class);
        $serverRequestMock->method('getCookieParams')->willReturn([
            'test' => 'value',
        ]);

        /** @var RequestProviderInterface $requestProvider */
        $requestProvider = $this->createMock(RequestProviderInterface::class);
        $requestProvider->method('get')->willReturn($serverRequestMock);


        return new RequestCookies($requestProvider);
    }
}
