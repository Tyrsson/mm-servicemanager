<?php

declare(strict_types=1);

namespace App;

use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;

interface DispatchableInterface
{
    public function attach(EventManagerInterface $events, $priority = 1);

    public function onDispatch(EventInterface $event): ?ResponseInterface;
}
