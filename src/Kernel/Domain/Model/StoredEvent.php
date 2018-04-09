<?php

namespace App\Kernel\Domain\Model;

use App\Kernel\Domain\Event\DomainEvent;

class StoredEvent implements DomainEvent
{

    private $eventId;
    private $eventBody;
    private $occurredOn;
    private $typeName;
    private $executed;
    private $executedDate;

    public function __construct(string $aTypeName, \DateTime $anOccurredOn, string $anEventBody)
    {
        $this->eventBody = $anEventBody;
        $this->typeName = $aTypeName;
        $this->occurredOn = $anOccurredOn;
        $this->executed = false;
    }

    public function eventBody() : string
    {
        return $this->eventBody;
    }

    public function eventId() : int
    {
        return $this->eventId;
    }

    public function typeName() : string
    {
        return $this->typeName;
    }

    public function occurredOn(): \DateTime
    {
        return $this->occurredOn;
    }
}
