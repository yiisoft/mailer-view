<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\MessageBodyRenderer\WithTemplate;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

final class WithTemplateTest extends TestCase
{
    public function testBase(): void
    {
        $baseRenderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(__DIR__ . '/views1')
        );

        $renderer = $baseRenderer->withTemplate(
            new MessageBodyTemplate(__DIR__ . '/views2')
        );

        $baseContent = $baseRenderer->renderText('content');
        $content = $renderer->renderText('content');

        $this->assertNotSame($baseRenderer, $renderer);
        $this->assertSame('one', $baseContent);
        $this->assertSame('two', $content);
    }
}
