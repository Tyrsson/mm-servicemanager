<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

final class DepOneFactory
{
    public function __invoke(ContainerInterface $container): DepOne
    {
        return new DepOne($container->get(DepTwo::class));
    }
}
