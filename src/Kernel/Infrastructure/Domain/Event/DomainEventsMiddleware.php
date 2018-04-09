<?php


namespace App\Kernel\Infrastructure\Domain\Event;

use App\Kernel\Application\EventStore;
use App\Kernel\Domain\Event\DomainEventPublisher;
use App\Kernel\Domain\Event\DomainEventSubscriber;
use League\Tactician\Middleware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DomainEventsMiddleware implements Middleware
{
    private $eventStore;
    private $eventDispatcher;

    public function __construct(
        EventStore $eventStore,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventStore = $eventStore;
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
            $this->eventStore->append($event);
            $listeners = $this->eventDispatcher->getListeners($event::NAME);
            foreach ($listeners as $listener) {
                if (is_object($listener[0]) && $listener[0] instanceof DomainEventSubscriber) {
                    if (!defined(get_class($listener[0]) . '::ASYNCHRONOUS') || !$listener[0]::ASYNCHRONOUS) {
                        call_user_func($listener, $event);
                    }
                }
            }
        }

        return $returnValue;
    }
}
