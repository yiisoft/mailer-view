<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ViewMailer\WithTemplate;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\StubMailer;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\Mailer\View\ViewMailer;
use Yiisoft\View\View;

final class WithTemplateTest extends TestCase
{
    public function testBase(): void
    {
        $mailer = new StubMailer();
        $baseViewMailer = new ViewMailer(
            $mailer,
            new MessageBodyRenderer(
                new View(),
                new MessageBodyTemplate(__DIR__ . '/views1')
            ),
        );

        $viewMailer = $baseViewMailer->withTemplate(
            new MessageBodyTemplate(__DIR__ . '/views2')
        );

        $baseMessage = $baseViewMailer->compose('content');
        $message = $viewMailer->compose('content');

        $this->assertNotSame($baseViewMailer, $viewMailer);
        $this->assertSame('one', $baseMessage->getHtmlBody());
        $this->assertSame('two', $message->getHtmlBody());
    }
}
