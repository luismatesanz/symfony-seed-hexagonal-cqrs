<?php

namespace App\Kernel\Domain\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $aDomainEvent);
}
