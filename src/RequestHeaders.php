<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider;

final class RequestHeaders {
    /**
     * @param RequestProviderInterface $requestProvider
     */
    public function __construct(
        private readonly RequestProviderInterface $requestProvider
    ) {
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getHeaderLine(string $name, string $default = null): string|null {
        return $this->requestProvider->get()->hasHeader($name) ? $this->requestProvider->get()->getHeaderLine($name) : $default;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getHeader(string $name): array {
        return $this->requestProvider->get()->getHeader($name);
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->requestProvider->get()->getHeaders();
    }

    /**
     * @return array
     */
    public function getFirstHeaders(): array {
        return array_map(static fn(array $lines) => $lines[0], $this->getHeaders());
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasHeader(string $name): bool {
        return $this->requestProvider->get()->hasHeader($name);
    }
}
