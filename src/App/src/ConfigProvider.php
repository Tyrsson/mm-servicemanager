<?php

declare(strict_types=1);

namespace App;

use App\Container;
use App\Actions\Action;
use App\Actions\Listener\LoginListener;
use App\Actions\LoginAction;
use App\Container\MessageListenerFactory;
use App\Container\RequestAwareDelegatorFactory;
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
            'listeners'      => [], // list of listeners to attach, easy for mod authors
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
                Actions\ActionManager::class => Actions\Container\ActionManagerFactory::class,
                App::class              => Container\AppFactory::class,
                BoardListener::class    => Container\BoardListenerFactory::class,
                DisplayListener::class  => Container\DisplayListenerFactory::class,
                EmitterInterface::class => Container\EmitterFactory::class,
                EventManager::class     => Container\EventManagerFactory::class,
                LoginListener::class    => InvokableFactory::class,
                MessageListener::class  => Container\MessageListenerFactory::class,
                TemplateManager::class  => Container\TemplateManagerFactory::class,
            ],
        ];
    }

    public function getActionManagerConfig(): array
    {
        return [
            'aliases'   => [
                Action::login->value => LoginAction::class,
            ],
            'delegators' => [
                LoginAction::class => [
                    RequestAwareDelegatorFactory::class, // runs only for LoginAction
                ],
            ],
            'factories' => [
                LoginAction::class   => Actions\Container\LoginActionFactory::class,
            ],
            'initializers' => [
                Actions\Container\EventManagerAwareInitializer::class, // Runs for all services created by ActionManager
            ],
        ];
    }
}
