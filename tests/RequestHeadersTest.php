<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\RequestProvider\RequestHeaders;
use Yiisoft\RequestProvider\RequestProviderInterface;

final class RequestHeadersTest extends TestCase {
    private const HEADER_NAME = 'test';
    private const HEADER_VALUE = 'value';

    /**
     * @return void
     * @throws Exception
     */
    public function testGetHeaderLine(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame(self::HEADER_VALUE, $requestHeaders->getHeaderLine(self::HEADER_NAME));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetHeader(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_VALUE], $requestHeaders->getHeader(self::HEADER_NAME));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetHeaders(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => [self::HEADER_VALUE]], $requestHeaders->getHeaders());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetFirstHeader(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame([self::HEADER_NAME => self::HEADER_VALUE], $requestHeaders->getFirstHeaders());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHasHeader(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertTrue($requestHeaders->hasHeader(self::HEADER_NAME));
        $this->assertFalse($requestHeaders->hasHeader('non-exist'));
    }

    /**
     * @param array $headers
     * @return RequestHeaders
     * @throws Exception
     */
    private function createRequestHeaders(array $headers = []): RequestHeaders {
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

        return new RequestHeaders($requestProvider);
    }
}
