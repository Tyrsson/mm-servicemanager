<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

final class ApplicationFactory
{
    public function __invoke(ContainerInterface $container): Application
    {
        return new Application(
            $container->get(DepOne::class),
            $container->get(DepTwo::class)
        );
    }
}
