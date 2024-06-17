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

use function array_merge;
use function array_unique;
use function compact;

final class App implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    private $defaultListeners = [
        BoardListener::class,
        MessageListener::class,
        DisplayListener::class,
        ActionListener::class,
        TemplateManager::class,
    ];

    public function __construct(
        private ServiceManager $serviceManager,
        private ServerRequestInterface $request,
        private EmitterInterface $emitter
    ) {
    }

    public function run()
    {
        $config = $this->serviceManager->get('config');
        $this->bootstrap($config['listeners']);
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

    private function bootstrap(array $listeners = []): self
    {
        $eventManager = $this->getEventManager();
        $listeners    = array_unique(array_merge($this->defaultListeners, $listeners));
        // lets setup and attach our default listeners
        foreach ($listeners as $listener) {
            $this->serviceManager->get($listener)->attach($eventManager);
        }
        // setup the bootstrap event in case any mods needs to get in on the action
        $event = new AppEvent();
        $event->setName(AppEvents::Bootstrap->value);
        $event->setTarget($this);
        $event->setApp($this);
        $event->setRequest($this->request);
        $eventManager->triggerEvent($event);

        return $this;
    }
}
