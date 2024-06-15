<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use function compact;

final class Application implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    public function __construct(
        private ServerRequestInterface $request,
        private EmitterInterface $emitter
    ) {
    }

    public function run()
    {
        $this->dispatch($this->request);
    }

    private function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null)
    {
        $argv = compact('request', 'response');
        $results = $this->getEventManager()->triggerUntil(function($returnedResponse) {
            return ($returnedResponse instanceof ResponseInterface);
        }, __FUNCTION__, $this, $argv);

        if ($results->stopped()) {
            $this->emitter->emit($results->last());
        } else {
            $this->emitter->emit(new HtmlResponse('<b>Not Found</b>', 404));
        }
    }
}
