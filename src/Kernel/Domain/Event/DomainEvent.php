<?php

namespace App\Kernel\Domain\Event;

interface DomainEvent
{
    public static function nameEvent();
    public function occurredOn();
}
