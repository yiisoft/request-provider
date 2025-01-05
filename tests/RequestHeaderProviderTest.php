<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestHeaderProvider;
use Yiisoft\RequestProvider\RequestProviderInterface;

use function array_key_exists;

final class RequestHeaderProviderTest extends TestCase
{
    private const HEADER_NAME = 'test';
    private const HEADER_VALUE = 'value';

    public function testGetLine(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame(self::HEADER_VALUE, $requestHeaders->getLine(self::HEADER_NAME));
    }

    public function testGet(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_VALUE], $requestHeaders->get(self::HEADER_NAME));
    }

    public function testGetAll(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => [self::HEADER_VALUE]], $requestHeaders->getAll());
    }

    public function testGetFirstHeaders(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => self::HEADER_VALUE], $requestHeaders->getFirstHeaders());
    }

    public function testHas(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertTrue($requestHeaders->has(self::HEADER_NAME));
        $this->assertFalse($requestHeaders->has('non-exist'));
    }

    private function createRequestHeaders(array $headers = []): RequestHeaderProvider
    {
        /** @var ServerRequestInterface $serverRequestMock */
        $serverRequestMock = $this->createMock(ServerRequestInterface::class);
        $serverRequestMock
            ->method('getHeaderLine')
            ->willReturnCallback(fn(string $name): string => $headers[$name][0] ?? null);

        $serverRequestMock
            ->method('getHeader')
            ->willReturnCallback(fn(string $name): array => $headers[$name] ?? []);

        $serverRequestMock
            ->method('getHeaders')
            ->willReturnCallback(fn(): array => $headers);

        $serverRequestMock
            ->method('hasHeader')
            ->willReturnCallback(fn(string $name) => array_key_exists($name, $headers));

        /** @var RequestProviderInterface $requestProvider */
        $requestProvider = $this->createMock(RequestProviderInterface::class);
        $requestProvider->method('get')->willReturn($serverRequestMock);

        return new RequestHeaderProvider($requestProvider);
    }
}
