<?php

declare(strict_types=1);

namespace App\Actions\Listener;

use App\Actions\Action;
use App\Actions\LoginAction;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use User\Entity\User;

final class LoginListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(Action::login->value, [$this, 'onLogin'], 10000);
    }

    public function onLogin(EventInterface $event)
    {
        /** @var User */
        $user = $event->getParam('userInstance');
        $user->exchangeArray($event->getParam('userData'));
        /** @var LoginAction */
        $target  = $event->getTarget();
    }
}
