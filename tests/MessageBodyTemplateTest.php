<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests;

use LogicException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\ViewMailer\MessageBodyTemplate;

final class MessageBodyTemplateTest extends TestCase
{
    public function testViewPathAsEmptyString(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('View path must be non-empty string.');
        new MessageBodyTemplate('');
    }

    public function testHtmlLayoutAsEmptyString(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The HTML layout view name must be non-empty string or null.');
        new MessageBodyTemplate('/', htmlLayout: '');
    }

    public function testTextLayoutAsEmptyString(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The text layout view name must be non-empty string or null.');
        new MessageBodyTemplate('/', textLayout: '');
    }
}
