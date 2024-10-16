<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px" alt="Yii">
    </a>
    <h1 align="center">Yii Mailer View</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiisoft/mailer-view/v)](https://packagist.org/packages/yiisoft/mailer-view)
[![Total Downloads](https://poser.pugx.org/yiisoft/mailer-view/downloads)](https://packagist.org/packages/yiisoft/mailer-view)
[![Build status](https://github.com/yiisoft/mailer-view/actions/workflows/build.yml/badge.svg)](https://github.com/yiisoft/mailer-view/actions/workflows/build.yml)
[![Code Coverage](https://codecov.io/gh/yiisoft/mailer-view/branch/master/graph/badge.svg)](https://codecov.io/gh/yiisoft/mailer-view)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fmailer-view%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/mailer-view/master)
[![static analysis](https://github.com/yiisoft/mailer-view/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/mailer-view/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/mailer-view/coverage.svg)](https://shepherd.dev/github/yiisoft/mailer-view)
[![psalm-level](https://shepherd.dev/github/yiisoft/mailer-view/level.svg)](https://shepherd.dev/github/yiisoft/mailer-view)

This [Yii Mailer](https://github.com/yiisoft/mailer) extension provides classes for composing message body via view
rendering:

- `MessageBodyRenderer` - a view renderer used to compose message body.
- `ViewMailer` - a mailer decorator with `compose()` method.

## Requirements

- PHP 8.1 or higher.

## Installation

The package could be installed with [Composer](https://getcomposer.org):

```shell
composer require yiisoft/mailer-view
```

## General usage

### Message body renderer

```php
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

$renderer = new MessageBodyRenderer(
    new View(),
    new MessageBodyTemplate(
        __DIR__ . '/views',
        'html-layout',
    ),
);

// HTML body
$htmlBody = $renderer->renderHtml(
    view: 'html-content',
    viewParameters: ['count' => 42],
    layoutParameters: ['header' => 'Hello!'],
);

// Text body
$textBody = $renderer->renderText(
    view: 'html-content',
    viewParameters: ['count' => 42],
    layoutParameters: ['header' => 'Hello!'],
);

// Add body to message
$message = $renderer->addBodyToMessage(
    message: new Message(),
    htmlView: 'html-content',
    viewParameters: ['count' => 42],
    layoutParameters: ['header' => 'Hello!'],
);
```

If needed, you can pass `textView` parameter with the name of the text view.

### Mailer decorator

```php
/**
 * @var \Yiisoft\Mailer\MailerInterface $mailer
 * @var Yiisoft\Mailer\View\MessageBodyRenderer $messageBodyRenderer
 */
 
$viewMailer = new ViewMailer($mailer, $messageBodyRenderer);

// Create message
$message = $viewMailer->compose(
    htmlView: 'html-content',
    viewParameters: ['count' => 42],
    layoutParameters: ['header' => 'Hello!'],
);

// Send message
$viewMailer->send($message);
```

If needed, you can pass `textView` parameter with the name of the text view.

## Documentation

- [Internals](docs/internals.md)

If you need help or have a question, the [Yii Forum](https://forum.yiiframework.com/c/yii-3-0/63) is a good place
for that. You may also check out other [Yii Community Resources](https://www.yiiframework.com/community).

## License

The Yii Mailer View is free software. It is released under the terms of the BSD License.
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
