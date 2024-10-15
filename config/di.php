<?php

declare(strict_types=1);

use Yiisoft\Aliases\Aliases;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Mailer\View\MessageBodyRenderer;
use Yiisoft\Mailer\View\MessageBodyTemplate;

/**
 * @var array $params
 */

return [
    MessageBodyRenderer::class => [
        '__construct()' => [
            'template' => DynamicReference::to(
                static fn(?Aliases $aliases = null) => new MessageBodyTemplate(
                    $aliases === null
                        ? $params['yiisoft/mailer-view']['viewPath']
                        : $aliases->get($params['yiisoft/mailer-view']['viewPath']),
                    $params['yiisoft/mailer-view']['htmlLayout'],
                    $params['yiisoft/mailer-view']['textLayout'],
                ),
            ),
        ],
    ],
];
