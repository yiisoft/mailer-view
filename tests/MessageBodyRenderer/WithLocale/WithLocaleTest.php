<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\MessageBodyRenderer\WithLocale;

use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

final class WithLocaleTest extends TestCase
{
    public function testBase(): void
    {
        $baseRenderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(__DIR__ . '/views')
        );

        $renderer = $baseRenderer->withLocale('ru_RU');

        $baseContent = $baseRenderer->renderText('content');
        $content = $renderer->renderText('content');

        $this->assertNotSame($baseRenderer, $renderer);
        $this->assertSame('English', $baseContent);
        $this->assertSame('Русский', $content);
    }
}
