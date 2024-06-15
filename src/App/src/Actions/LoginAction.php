<?php

declare(strict_types=1);

namespace App\Actions;

use App\RequestAwareInterface;
use App\RequestAwareTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use User\Entity\User;
use User\UserInterface;

final class LoginAction extends AbstractAction implements RequestAwareInterface
{
    use RequestAwareTrait;

    public function __construct(
        private UserInterface&User $user
    ) {
    }

    public function run(): ?ResponseInterface
    {
        /** @var ServerRequest */
        $result = $this->getEventManager()->trigger(Action::login->value, $this, [
            'userData' => [
                'userName' => 'Tyrsson',
                'userId' => 1,
                'role' => 'Administrator'
            ],
            'userInstance' => $this->user,
        ]);
        return new HtmlResponse('<b>LoginAction is running.</b>');
    }
}
