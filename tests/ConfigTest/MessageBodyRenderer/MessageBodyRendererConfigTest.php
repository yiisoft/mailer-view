<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ConfigTest\MessageBodyRenderer;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\Tests\ConfigTest\ConfigTestCase;

final class MessageBodyRendererConfigTest extends ConfigTestCase
{
    public function testBase(): void
    {
        $container = new Container(
            ContainerConfig::create()
                ->withDefinitions(
                    $this->getDiConfig() + [
                        Aliases::class => [
                            '__construct()' => [
                                [
                                    'resources' => __DIR__ . '/resources',
                                ],
                            ],
                        ],
                    ]
                )
        );

        $renderer = $container->get(MessageBodyRenderer::class);
        $html = $renderer->renderHtml('html-content', ['number' => 42]);
        $text = $renderer->renderText('text-content', ['number' => 42]);

        $this->assertInstanceOf(MessageBodyRenderer::class, $renderer);
        $this->assertSame('<p>Number: 42.</p>', $html);
        $this->assertSame('Number: 42.', $text);
    }
}
