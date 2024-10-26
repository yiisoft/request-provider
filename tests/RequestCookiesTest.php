<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\RequestProvider\RequestCookies;
use Yiisoft\RequestProvider\RequestProviderInterface;

use function dirname;

final class RequestCookiesTest extends TestCase
{

    public function testRequestCookiesGet(): void
    {
        $requestCoockies = $this->getRequestCookies();

        $this->assertSame('value', $requestCoockies->get('test'));
    }

    public function testRequestCookiesHas(): void
    {
        $requestCoockies = $this->getRequestCookies();

        $this->assertTrue($requestCoockies->has('test'));

        $this->assertFalse($requestCoockies->has('value'));
    }

    private function getRequestCookies(): RequestCookies
    {
        $container = $this->createContainer();
        $requestProvider = $container->get(RequestProviderInterface::class);
        $serverRequestMock = $this->createMock(ServerRequestInterface::class);
        $serverRequestMock->method('getCookieParams')->willReturn([
            'test' => 'value',
        ]);
        $requestProvider->set($serverRequestMock);

        /** @var RequestCookies $requestCoockies */
        return $container->get(RequestCookies::class);
    }

    private function createContainer(): Container
    {
        return new Container(
            ContainerConfig::create()->withDefinitions($this->getContainerDefinitions())
        );
    }

    private function getContainerDefinitions(): array
    {
        return require dirname(__DIR__) . '/config/di-web.php';
    }
}
