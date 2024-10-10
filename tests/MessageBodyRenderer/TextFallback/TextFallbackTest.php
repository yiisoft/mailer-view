<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\MessageBodyRenderer\TextFallback;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Mailer\Message;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;
use Yiisoft\View\View;

final class TextFallbackTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield [
            <<<TEXT
            HTML view file content http://yiifresh.com/index.php?r=site%2Freset-password&token=abcdef
            TEXT,
            'case1',
        ];
        yield [
            <<<TEXT
            First paragraph
            second line: 'hello', "world"

            http://yiifresh.com/index.php?r=site%2Freset-password&token=abcdef

            Test Lorem ipsum...
            TEXT,
            'case2',
        ];
        yield [
            'Hello',
            'case3',
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedText, string $view): void
    {
        $renderer = new MessageBodyRenderer(
            new View(),
            new MessageBodyTemplate(__DIR__ . '/views'),
        );

        $message = $renderer->addBodyToMessage(new Message(), $view);

        $this->assertSame($expectedText, $message->getTextBody());
    }
}
