<?php

declare(strict_types=1);

namespace App;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;

final class TemplateManager extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events, $priority = 1)
    {

    }
}
