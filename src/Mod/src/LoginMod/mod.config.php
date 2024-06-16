<?php

declare(strict_types=1);

namespace Mod\LoginMod;

return [
    'dependencies' => [
        'factories' => [
            LoginListener::class => LoginListenerFactory::class,
        ],
    ],
    'mod_listeners' => [
        LoginListener::class,
    ],
];