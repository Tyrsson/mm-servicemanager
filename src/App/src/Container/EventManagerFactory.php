<?php

declare(strict_types=1);

namespace App\Container;

use Laminas\EventManager\EventManager;
use Laminas\EventManager\SharedEventManager;
use Psr\Container\ContainerInterface;

final class EventManagerFactory
{
    public function __invoke(ContainerInterface $container): EventManager
    {
        return new EventManager(new SharedEventManager());
    }
}
