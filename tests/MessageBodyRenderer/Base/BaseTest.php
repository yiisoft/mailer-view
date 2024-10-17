<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\MessageBodyRenderer\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\Message;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

final class BaseTest extends TestCase
{
    public function testBase(): void
    {
        $renderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(
                __DIR__ . '/views',
                'html-layout',
                'text-layout',
            ),
        );
        $viewParameters = ['number' => 42];
        $layoutParameters = ['title' => 'Hello!'];

        $message = $renderer->addBodyToMessage(
            new Message(),
            'html-content',
            $viewParameters,
            $layoutParameters,
            'text-content',
        );
        $htmlBody = $renderer->renderHtml('html-content', $viewParameters, $layoutParameters);
        $textBody = $renderer->renderText('text-content', $viewParameters, $layoutParameters);

        $expectedHtml = <<<HTML
            <h1>Hello!</h1>
            <p>Number: 42.</p>
            HTML;
        $expectedText = <<<TEXT
            Hello!
            ===

            Number: 42.
            TEXT;

        $this->assertSame($expectedHtml, $message->getHtmlBody());
        $this->assertSame($expectedText, $message->getTextBody());
        $this->assertSame($expectedHtml, $htmlBody);
        $this->assertSame($expectedText, $textBody);
    }

    public function testWithoutTextView(): void
    {
        $renderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(
                __DIR__ . '/views',
                'html-layout',
                'text-layout',
            ),
        );
        $viewParameters = ['number' => 42];
        $layoutParameters = ['title' => 'Hello!'];

        $message = $renderer->addBodyToMessage(
            new Message(),
            'html-content',
            $viewParameters,
            $layoutParameters,
        );

        $expectedHtml = <<<HTML
            <h1>Hello!</h1>
            <p>Number: 42.</p>
            HTML;

        $this->assertSame($expectedHtml, $message->getHtmlBody());
        $this->assertNull($message->getTextBody());
    }

    public function testRenderTextWithoutTextLayout(): void
    {
        $renderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(__DIR__ . '/views'),
        );

        $result = $renderer->renderText('text-content', ['number' => 42]);

        $this->assertSame(
            "\nNumber: 42.",
            $result,
        );
    }
}
