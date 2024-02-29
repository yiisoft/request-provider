<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Di\StateResetter;
use Yiisoft\RequestProvider\RequestNotSetException;
use Yiisoft\RequestProvider\RequestProvider;
use Yiisoft\RequestProvider\RequestProviderInterface;

use function dirname;

final class ConfigTest extends TestCase
{
    public function testDi(): void
    {
        $container = $this->createContainer();

        $this->assertInstanceOf(RequestProvider::class, $container->get(RequestProviderInterface::class));
    }

    public function testResetRequestProvider(): void
    {
        $container = $this->createContainer();

        $requestProvider = $container->get(RequestProviderInterface::class);
        $requestProvider->set($this->createMock(ServerRequestInterface::class));

        $container->get(StateResetter::class)->reset();

        $this->expectException(RequestNotSetException::class);
        $requestProvider->get();
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
