<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;

abstract class AbstractAction implements ActionInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;
}
