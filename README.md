<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
    </a>
    <h1 align="center">Yii Request Provider</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiisoft/request-provider/v/stable.png)](https://packagist.org/packages/yiisoft/request-provider)
[![Total Downloads](https://poser.pugx.org/yiisoft/request-provider/downloads.png)](https://packagist.org/packages/yiisoft/request-provider)
[![Build status](https://github.com/yiisoft/request-provider/workflows/build/badge.svg)](https://github.com/yiisoft/request-provider/actions?query=workflow%3Abuild)
[![Code Coverage](https://codecov.io/gh/yiisoft/request-provider/branch/master/graph/badge.svg)](https://codecov.io/gh/yiisoft/request-provider)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Frequest-provider%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/request-provider/master)
[![static analysis](https://github.com/yiisoft/request-provider/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/request-provider/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/request-provider/coverage.svg)](https://shepherd.dev/github/yiisoft/request-provider)
[![psalm-level](https://shepherd.dev/github/yiisoft/request-provider/level.svg)](https://shepherd.dev/github/yiisoft/request-provider)

The package provides current PSR-7 request as a dependency.

## Requirements

- PHP 8.1 or higher.

## Installation

The package could be installed with composer:

```shell
composer require yiisoft/request-provider
```

Then add `Yiisoft\RequestProvider\RequestCatcherMiddleware` to your application middleware stack.

## General usage

When you need current request, get `RequestProviderInterface` as dependency and obtain the request from it: 

```php
use \Yiisoft\RequestProvider\RequestProviderInterface;

final class MyService
{
    public function __construct(
        private readonly RequestProviderInterface $requestProvider
    )
    {    
    }
    
    public function doIt()
    {
        $request = $this->requestProvider->get();
        // ...
    }
}
```

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

### Code style

Use [Rector](https://github.com/rectorphp/rector) to make codebase follow some specific rules or 
use either newest or any specific version of PHP: 

```shell
./vendor/bin/rector
```

### Dependencies

Use [ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker) to detect transitive 
[Composer](https://getcomposer.org/) dependencies.

## License

The Yii request-provider is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)
