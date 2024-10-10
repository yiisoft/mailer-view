<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ViewMailer\WithLocale;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\NullMailer;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\Mailer\View\ViewMailer;
use Yiisoft\View\View;

final class WithLocaleTest extends TestCase
{
    public function testBase(): void
    {
        $baseMailer = new ViewMailer(
            new NullMailer(),
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__ . '/views')
            ),
        );

        $mailer = $baseMailer->withLocale('ru_RU');

        $baseMessage = $baseMailer->compose('content');
        $message = $mailer->compose('content');

        $this->assertNotSame($baseMailer, $mailer);
        $this->assertSame('English', $baseMessage->getHtmlBody());
        $this->assertSame('Русский', $message->getHtmlBody());
    }
}
