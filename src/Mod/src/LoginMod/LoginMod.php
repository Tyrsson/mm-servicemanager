<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use Mod\LoginMod\Entity\LoginThingy;

final class LoginMod
{
    public function __construct(
        private Entity\LoginThingy $loginThingy
    ) {
    }
}
