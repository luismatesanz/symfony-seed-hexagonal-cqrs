<?php

namespace App\Kernel\Infrastructure\Domain\Event;

use App\Kernel\Domain\Event\DomainEvent;
use App\Kernel\Domain\Event\DomainEventSubscriber;

class CollectionInMemoryDomainEventSubscriber implements DomainEventSubscriber
{
    private $events;

    public function __construct()
    {
        $this->events = [];
    }

    public static function getSubscribedEvents()
    {
    }

    public function isSubscribedTo($aDomainEvent)
    {
        return true;
    }

    public function handle($aDomainEvent)
    {
        $this->events[] = $aDomainEvent;
    }

    public function events(): array
    {
        return $this->events;
    }

    public function handleEvent(DomainEvent $event)
    {
        return $this->handle($event);
    }
}