<?php

declare(strict_types=1);

namespace App;

use App\Actions\Action;
use App\Actions\ActionManager;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;

final class ActionListener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

    public function __construct(
        private ActionManager $actionManager
    ) {
    }

    public function onDispatch(EventInterface $event): ?ResponseInterface
    {
        /** @var ServerRequest */
        $request = $event->getParam('request');
        $params  = $request->getQueryParams();

        if (! empty($params['action'])) {
            try {
                /**
                 * $action is the action=someaction
                 * it must be a valid value for the Action enum which codifies known actions
                 */
                $action = Action::tryFrom($params['action']) ?? 'unknown';
                /**
                 * The called action must return a ResponseInterface instance or it will 404
                 */
                return ($this->actionManager->get($action->value))->run();
            } catch (ServiceNotFoundException $e) {
                // todo: handle catching this....
            }
        }
    }
}
