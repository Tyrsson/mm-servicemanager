<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use App\Actions\Action;
use App\AppEvent;
use App\AppEvents;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use User\Entity\User;
use User\UserInterface;

final class Listener extends AbstractListenerAggregate
{
    public function __construct(
        private Entity\LoginThingy $loginThingy,
        private UserInterface&User $user,
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvents::Bootstrap->value, [$this, 'onBootstrap'], $priority);
        $this->listeners[] = $events->attach(Action::login->value, [$this, 'onLogin'], $priority);
    }

    public function onBootstrap(AppEvent $event)
    {
        $app = $event->getApp();
    }

    public function onLogin(EventInterface $event)
    {
        $user = $event->getParam('userInstance');
        $user->modProperty = 'Some Mod Value';
    }
}
