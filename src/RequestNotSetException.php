<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider;

use LogicException;
use Throwable;
// use Yiisoft\Input\Http\Request\Catcher\RequestCatcherMiddleware;
// use Yiisoft\Input\Http\Request\Catcher\RequestCatcherParametersResolver;s

/**
 * Thrown when request isn't set by either {@see RequestCatcherMiddleware} or {@see RequestCatcherParametersResolver}.
 */
final class RequestNotSetException extends LogicException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Request is not set.', $code, $previous);
    }
}
