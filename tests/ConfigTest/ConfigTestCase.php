<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View\Tests\ConfigTest;

use PHPUnit\Framework\TestCase;

use function dirname;

abstract class ConfigTestCase extends TestCase
{
    final protected function getDiConfig(?array $params = null): array
    {
        $params ??= $this->getParams();
        return require dirname(__DIR__, 2) . '/config/di.php';
    }

    final protected function getParams(): array
    {
        return require dirname(__DIR__, 2) . '/config/params.php';
    }
}
