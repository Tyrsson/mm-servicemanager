<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use App\Actions\Action;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use User\Entity\User;
use User\UserInterface;

final class LoginListener extends AbstractListenerAggregate
{
    public function __construct(
        private UserInterface&User $user,
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(Action::login->value, [$this, 'onLogin'], $priority);
    }

    public function onLogin(EventInterface $event)
    {
        $user = $event->getParam('userInstance');
        $user->modProperty = 'Some Mod Value';
    }
}
