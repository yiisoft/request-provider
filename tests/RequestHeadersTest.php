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
     */
    public function testGet(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertSame(self::HEADER_VALUE, $requestHeaders->get(self::HEADER_NAME));
    }

    /**
     * @return void
     */
    public function testHas(): void {
        $requestHeaders = $this->createRequestHeaders([self::HEADER_NAME => [self::HEADER_VALUE]]);

        $this->assertTrue($requestHeaders->has(self::HEADER_NAME));
        $this->assertFalse($requestHeaders->has('non-exist'));
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
            ->method('hasHeader')
            ->willReturnCallback(fn(string $name) => array_key_exists($name, $headers));

        /** @var RequestProviderInterface $requestProvider */
        $requestProvider = $this->createMock(RequestProviderInterface::class);
        $requestProvider->method('get')->willReturn($serverRequestMock);

        return new RequestHeaders($requestProvider);
    }
}
