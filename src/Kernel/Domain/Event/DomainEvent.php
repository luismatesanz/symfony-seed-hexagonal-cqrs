<?php

namespace App\Kernel\Domain\Event;

interface DomainEvent
{
    public function occurredOn();
}
