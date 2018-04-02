<?php

namespace App\Kernel\Domain\Event;

interface DomainEventDispatcher
{
    public function notify(
        array $events,
        bool $asynchronous = false,
        string $nameQueue = ""
    );

    public function dispatch(
        string $eventName,
        DomainEvent $event = null,
        bool $asynchronous = false,
        string $nameQueue = ""
    );
}