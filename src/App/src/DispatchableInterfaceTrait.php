<?php

declare(strict_types=1);

namespace App;

use Laminas\EventManager\EventManagerInterface;

trait DispatchableInterfaceTrait
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('dispatch', [$this, 'onDispatch'], $priority);
    }
}
