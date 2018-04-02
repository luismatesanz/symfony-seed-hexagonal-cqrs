<?php

declare(strict_types = 1);

namespace App\Kernel\Domain\Event;

trait TriggerEventsTrait
{

    private $events = [];

    public function trigger(DomainEvent $event) : void
    {
        $this->events[] = $event;
    }

    public function getEvents() : array
    {
        return $this->events;
    }
}