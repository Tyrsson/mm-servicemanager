<?php

declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;

interface ActionInterface
{
    public function run(): ?ResponseInterface;
}
