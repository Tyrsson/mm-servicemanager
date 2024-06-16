<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use Psr\Container\ContainerInterface;
use User\UserInterface;

final class LoginListenerFactory
{
    public function __invoke(ContainerInterface $container): LoginListener
    {
        return new LoginListener($container->get(UserInterface::class));
    }
}
