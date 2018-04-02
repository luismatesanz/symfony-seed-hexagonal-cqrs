<?php


namespace App\Kernel\Infrastructure\Domain\Event;


use App\Kernel\Domain\Event\DomainEventPublisher;
use League\Tactician\Middleware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DomainEventsMiddleware implements Middleware
{
    private $eventDispatcher;
    public function __construct(
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($command, callable $next)
    {
        $domainEventPublisher = DomainEventPublisher::instance();
        $domainEventsCollector = new CollectionInMemoryDomainEventSubscriber();
        $domainEventPublisher->subscribe($domainEventsCollector);

        $returnValue = $next($command);

        // ALL EVENTS
        $events = $domainEventsCollector->events();
        foreach ($events as $event) {
            $listeners = $this->eventDispatcher->getListeners($event::nameEvent());
            foreach ($listeners as $listener) {
                if (property_exists($listener[0],'asynchronous') && $listener[0]->asynchronous) {
                    // TODO: CREATE ASYNCHRONOUS DOMAIN EVENTS SEND AND CONSUMER SYMFONY EVENT DISPATCHER
                } else {
                    call_user_func($listener, $event);
                }
            }
        }

        return $returnValue;
    }


}