<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\MessageBodyRenderer\WithView;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

final class WithViewTest extends TestCase
{
    public function testBase(): void
    {
        $baseRenderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(__DIR__ . '/views')
        );

        $renderer = $baseRenderer->withView(
            (new View)->withFallbackExtension('txt')
        );

        $baseContent = $baseRenderer->renderText('content');
        $content = $renderer->renderText('content');

        $this->assertNotSame($baseRenderer, $renderer);
        $this->assertSame('From PHP', $baseContent);
        $this->assertSame("From TXT\n", $content);
    }
}
