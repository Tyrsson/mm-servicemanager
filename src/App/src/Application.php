<?php

declare(strict_types=1);

namespace App;

final class Application
{
    public function __construct(
        private DepOne $depOne,
        private DepTwo $depTwo
    ) {
    }

    public function run()
    {

    }
}
