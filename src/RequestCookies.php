<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider;

use function array_key_exists;

final class RequestCookies
{
    public function __construct(
        private readonly RequestProviderInterface $requestProvider,
    ) {
    }

    public function get(string $name): ?string
    {
        /**
         * @var string|null Cookie value is always string.
         */
        return $this->requestProvider->get()->getCookieParams()[$name] ?? null;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->requestProvider->get()->getCookieParams());
    }
}
