<?php

namespace Yiisoft\RequestProvider;

use Psr\Http\Message\ServerRequestInterface;

final class RequestHeaders {
    private ServerRequestInterface $request;

    /**
     * @param RequestProviderInterface $requestProvider
     */
    public function __construct(
        RequestProviderInterface $requestProvider
    ) {
        $this->request = $requestProvider->get();
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function get(string $name): string|null {
        return $this->request->hasHeader($name) ? $this->request->getHeaderLine($name) : null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool {
        return $this->request->hasHeader($name);
    }
}
