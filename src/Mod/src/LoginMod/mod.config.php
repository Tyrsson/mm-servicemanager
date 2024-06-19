<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'dependencies' => [
        'factories' => [
            Entity\LoginThingy::class => InvokableFactory::class,
            Listener::class => ListenerFactory::class,
        ],
    ],
    'listeners' => [
        Listener::class,
    ],
];