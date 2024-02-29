<?php

declare(strict_types=1);

namespace Yiisoft\RequestProvider\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\RequestProvider\RequestNotSetException;

final class RequestNotSetExceptionTest extends TestCase
{
    public function testBase(): void
    {
        $exception = new RequestNotSetException();

        $this->assertSame('Request is not set.', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}
