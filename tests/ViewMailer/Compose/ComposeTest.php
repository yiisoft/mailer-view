<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ViewMailer\Compose;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\NullMailer;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\Mailer\View\ViewMailer;
use Yiisoft\View\View;

final class ComposeTest extends TestCase
{
    public function testBase(): void
    {
        $mailer = new ViewMailer(
            new NullMailer(),
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__ . '/views', 'layout'),
            ),
        );

        $message = $mailer->compose('content', ['number' => 42], ['title' => 'Hello!']);

        $this->assertSame(
            <<<HTML
            <h1>Hello!</h1>
            <p>Number: 42.</p>
            HTML,
            $message->getHtmlBody()
        );
        $this->assertSame(
            <<<TEXT
            Hello!
            Number: 42.
            TEXT,
            $message->getTextBody()
        );
    }

    public function testWithoutHtmlView(): void
    {
        $mailer = new ViewMailer(
            new NullMailer(),
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__ . '/views', 'layout'),
            ),
        );

        $message = $mailer->compose();

        $this->assertNull($message->getHtmlBody());
        $this->assertNull($message->getTextBody());
    }
}
