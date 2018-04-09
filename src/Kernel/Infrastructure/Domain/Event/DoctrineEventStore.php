<?php


namespace App\Kernel\Infrastructure\Domain\Event;

use App\Kernel\Application\EventStore;
use App\Kernel\Domain\Event\DomainEvent;
use App\Kernel\Domain\Model\StoredEvent;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class DoctrineEventStore extends EntityRepository implements EventStore
{
    private $serializer;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(EventStore::class));
    }

    public function append(DomainEvent $aDomainEvent)
    {
        $storedEvent = new StoredEvent(
            $this->getEventName($aDomainEvent),
            $aDomainEvent->occurredOn(),
            $this->serializer()->serialize($aDomainEvent, 'json')
        );

        $this->getEntityManager()->persist($storedEvent);
        $this->getEntityManager()->flush($storedEvent);
    }

    public function allStoredEventsSince(int $anEventId) : array
    {
        $query = $this->createQueryBuilder('e');
        if ($anEventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameters(array('eventId' => $anEventId));
        }
        $query->orderBy('e.eventId');

        return $query->getQuery()->getResult();
    }

    private function serializer() : Serializer
    {
        if (null === $this->serializer) {
            $this->serializer = SerializerBuilder::create()->build();
        }

        return $this->serializer;
    }

    private function getEventName($aDomainEvent) : string
    {
        $className = get_class($aDomainEvent);
        $arrayClassName = explode('\\', $className);
        return $arrayClassName[count($arrayClassName)-1];
    }
}