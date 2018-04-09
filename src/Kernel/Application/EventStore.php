<?php


namespace App\Kernel\Application;


use App\Kernel\Domain\Event\DomainEvent;

interface EventStore
{
    public function append(DomainEvent $aDomainEvent);
    public function allStoredEventsSince(int $anEventId) : array;
}