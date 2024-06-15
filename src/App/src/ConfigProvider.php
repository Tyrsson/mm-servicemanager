<?php

declare(strict_types=1);

namespace App;

use App\Container;
use App\Actions\Action;
use App\Actions\LoginAction;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies'   => $this->getDependencies(),
            'action_manager' => $this->getActionManagerConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                'EventManager'               => EventManagerInterface::class, // many underlying laminas components expect to find this Service Name
                EventManagerInterface::class => EventManager::class,
            ],
            'factories' => [
                ActionListener::class   => Container\ActionListenerFactory::class,
                Application::class      => Container\ApplicationFactory::class,
                BoardListener::class    => Container\BoardListenerFactory::class,
                DisplayListener::class  => Container\DisplayListenerFactory::class,
                EmitterInterface::class => Container\EmitterFactory::class,
                EventManager::class     => Container\EventManagerFactory::class,
                MessageListener::class  => Container\MessageListenerFactory::class,
                Actions\ActionManager::class => Actions\Container\ActionManagerFactory::class,
            ],
        ];
    }

    public function getActionManagerConfig(): array
    {
        return [
            'aliases'   => [
                Action::login->value => LoginAction::class,
            ],
            'factories' => [
                LoginAction::class => InvokableFactory::class,
            ],
            'initializers' => [
                Actions\Container\EventManagerAwareInitializer::class,
            ],
        ];
    }
}
