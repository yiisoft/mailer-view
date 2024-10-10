<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ViewMailer;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\Message;
use Yiisoft\Mailer\StubMailer;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\Mailer\View\ViewMailer;
use Yiisoft\View\View;

final class SendTest extends TestCase
{
    public function testSend(): void
    {
        $mailer = new StubMailer();
        $viewMailer = new ViewMailer(
            $mailer,
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__),
            ),
        );

        $message1 = new Message();
        $message2 = new Message();

        $viewMailer->send($message1);
        $viewMailer->send($message2);

        $this->assertSame([$message1, $message2], $mailer->getMessages());
    }

    public function testSendMultiple(): void
    {
        $mailer = new StubMailer();
        $viewMailer = new ViewMailer(
            $mailer,
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__),
            ),
        );

        $message1 = new Message();
        $message2 = new Message();

        $viewMailer->sendMultiple([$message1, $message2]);

        $this->assertSame([$message1, $message2], $mailer->getMessages());
    }
}
