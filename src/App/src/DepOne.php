<?php

declare(strict_types=1);

namespace App;

final class DepOne
{
    public function __construct(
        private DepTwo $depTwo
    ) {
    }
}
