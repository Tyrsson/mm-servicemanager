<?php

declare(strict_types=1);

namespace App;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [],
            'factories' => [
                Application::class => ApplicationFactory::class,
                DepOne::class      => DepOneFactory::class,
                DepTwo::class      => DepTwoFactory::class,
            ],
        ];
    }
}
