<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use function compact;

final class Application implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    public function __construct(
        private ServiceManager $serviceManager,
        private ServerRequestInterface $request,
        private EmitterInterface $emitter
    ) {
    }

    public function run()
    {
        $config = $this->serviceManager->get('config');
        $this->bootstrap($config['mod_listeners']);
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

    private function bootstrap(array $modListeners): void
    {
        $eventManager = $this->getEventManager();
        foreach ($modListeners as $mod) {
            $this->serviceManager->get($mod)->attach($eventManager);
        }
    }
}
