<?php

declare(strict_types = 1);

namespace App\Kernel\Infrastructure\Domain\Event;

use App\Kernel\Domain\Event\DomainEvent;
use App\Kernel\Domain\Event\DomainEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SymfonyDomainEventDispatcher implements DomainEventDispatcher
{
    private $eventDispatcher;

    public function __construct(
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function notify(
        array $events,
        bool $asynchronous = false,
        string $nameQueue = ""
    )
    {
        foreach ($events as $event) {
            $this->dispatch($event::nameEvent(), $event, $asynchronous, $nameQueue);
        }
    }

    public function dispatch(
        string $eventName,
        DomainEvent $event = null,
        bool $asynchronous = false,
        string $nameQueue = ""
    ){
        if (!$event) {
            throw new \InvalidArgumentException('Event not exists');
        }

        if ($asynchronous && $nameQueue === "") {
            throw new \InvalidArgumentException('Not especified name Queue.');
        }

        if ( !$asynchronous ) {
            $listeners = $this->eventDispatcher->getListeners($eventName);
            foreach ($listeners as $listener) {
                call_user_func($listener, $event);
            }
        } elseif ( $asynchronous ) {
            // TODO: Queue producer and consumer
        }
    }
}