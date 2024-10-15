<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ConfigTest\ViewMailer;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Mailer\MailerInterface;
use Yiisoft\Mailer\StubMailer;
use Yiisoft\Mailer\View\Tests\ConfigTest\ConfigTestCase;
use Yiisoft\Mailer\View\ViewMailer;
use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\View;

final class ViewMailerConfigTest extends ConfigTestCase
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
                        MailerInterface::class => StubMailer::class,
                    ]
                )
        );

        $viewMailer = $container->get(ViewMailer::class);

        $message = $viewMailer->compose('html-content', ['number' => 42], textView: 'text-content');
        $viewMailer->send($message);

        $sentMessages = $container->get(StubMailer::class)->getMessages();

        $this->assertInstanceOf(ViewMailer::class, $viewMailer);
        $this->assertSame([$message], $sentMessages);
        $this->assertSame('<p>Number: 42.</p>', $message->getHtmlBody());
        $this->assertSame('Number: 42.', $message->getTextBody());
    }

    public function testWithLayout(): void
    {
        $params = [
            'yiisoft/mailer-view' => [
                'viewPath' => '@resources/mail',
                'htmlLayout' => 'html-layout',
                'textLayout' => 'text-layout',
            ],
        ];
        $container = new Container(
            ContainerConfig::create()
                ->withDefinitions(
                    $this->getDiConfig($params) + [
                        Aliases::class => [
                            '__construct()' => [
                                [
                                    'resources' => __DIR__ . '/resources',
                                ],
                            ],
                        ],
                        MailerInterface::class => StubMailer::class,
                    ]
                )
        );

        $viewMailer = $container->get(ViewMailer::class);

        $message = $viewMailer->compose('html-content', ['number' => 42], ['title' => 'TEST'], 'text-content');
        $viewMailer->send($message);

        $sentMessages = $container->get(StubMailer::class)->getMessages();

        $this->assertInstanceOf(ViewMailer::class, $viewMailer);
        $this->assertSame([$message], $sentMessages);
        $this->assertSame(
            <<<HTML
            <h1>TEST</h1>
            <p>Number: 42.</p>
            HTML,
            $message->getHtmlBody()
        );
        $this->assertSame(
            <<<TEXT
            TEST
            ===
            Number: 42.
            TEXT,
            $message->getTextBody()
        );
    }

    public function testWithoutAlias(): void
    {
        $container = new Container(
            ContainerConfig::create()
                ->withDefinitions(
                    $this->getDiConfig() + [
                        View::class => View::class,
                        MailerInterface::class => [
                            'class' => StubMailer::class,
                        ],
                        ViewMailer::class => ViewMailer::class,
                    ]
                )
                ->withStrictMode()
        );

        $viewMailer = $container->get(ViewMailer::class);

        $this->assertInstanceOf(ViewMailer::class, $viewMailer);

        $this->expectException(ViewNotFoundException::class);
        $this->expectExceptionMessage('The view file "@resources/mail/html-content.php" does not exist.');
        $viewMailer->compose('html-content', ['number' => 42]);
    }
}
