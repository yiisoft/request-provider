<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Stores request for further consumption by attribute handlers.
 */
final class RequestProvider implements RequestProviderInterface
{
    /**
     * @param ServerRequestInterface|null $request The request.
     */
    public function __construct(
        private ?ServerRequestInterface $request = null,
    ) {}

    public function set(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function get(): ServerRequestInterface
    {
        if ($this->request === null) {
            throw new RequestNotSetException();
        }

        return $this->request;
    }
}
