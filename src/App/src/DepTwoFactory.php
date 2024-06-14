<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

final class DepTwoFactory
{
    public function __invoke(ContainerInterface $container): DepTwo
    {
        return new DepTwo($container->get('config'));
    }
}
