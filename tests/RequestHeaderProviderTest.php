<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestHeaderProvider;
use Yiisoft\RequestProvider\RequestProviderInterface;

final class RequestHeaderProviderTest extends TestCase
{
    private const HEADER_NAME = 'test';
    private const HEADER_VALUE = 'value';

    public function testGetHeaderLine(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame(self::HEADER_VALUE, $requestHeaders->getHeaderLine(self::HEADER_NAME));
    }

    public function testGetHeader(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_VALUE], $requestHeaders->getHeader(self::HEADER_NAME));
    }

    public function testGetHeaders(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => [self::HEADER_VALUE]], $requestHeaders->getHeaders());
    }

    public function testGetFirstHeader(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => self::HEADER_VALUE], $requestHeaders->getFirstHeaders());
    }

    public function testHasHeader(): void
    {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertTrue($requestHeaders->hasHeader(self::HEADER_NAME));
        $this->assertFalse($requestHeaders->hasHeader('non-exist'));
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
