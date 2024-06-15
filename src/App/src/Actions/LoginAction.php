<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

final class LoginAction extends AbstractAction
{

    public function run(): ?ResponseInterface
    {
        return new HtmlResponse('<b>LoginAction is running.</b>');
    }

}
