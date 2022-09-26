<?php

namespace srag\Plugins\TPMS\EventHandling\Infrastructure\Persistence;

use arException;
use Exception;
use srag\CQRS\TPMS\Aggregate\DomainObjectId;
use srag\CQRS\TPMS\Event\DomainEvent;
use srag\CQRS\TPMS\Event\DomainEvents;
use srag\CQRS\TPMS\Event\EventID;
use srag\CQRS\TPMS\Event\EventStore;
use srag\Plugins\TPMS\EventHandling\Infrastructure\Persistence\ActiveRecord\EventStoreAR;

/**
 * Class ilDBEventStore
 *
 * @package srag\Plugins\TPMS\EventHandling\Infrastructure\Persistence
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilDBEventStore implements EventStore
{

    /**
     * @inheritDoc
     */
    public function commit(DomainEvents $events)
    {
        /** @var DomainEvent $event */
        foreach ($events->getEvents() as $event) {
            $this->commitSingle($event);
        }
    }


    /**
     * @param DomainEvent $event
     *
     * @throws Exception
     */
    public function commitSingle(DomainEvent $event)
    {
        $stored_event = new EventStoreAR();
        $stored_event->setEventData(
            new EventID(),
            $event->getAggregateId(),
            $event->getEventName(),
            $event->getOccurredOn(),
            $event->getInitiatingUserId(),
            $event->getEventBody(),
            get_class($event)
        );

        $stored_event->create();
    }


    /**
     * @inheritDoc
     */
    public function getAggregateHistoryFor(DomainObjectId $id) : DomainEvents
    {
        $event_stream = new DomainEvents();
        foreach (EventStoreAR::where(['aggregate_id' => $id->getId()])->get() as $item) {
            /** @var EventStoreAR $item */
            $event_class = $item->getEventClass();
            $event = $event_class::restore(
                $item->getEventId(),
                $item->getAggregateId(),
                $item->getInitiatingUserId(),
                $item->getOccurredOn(),
                $item->getEventBody()
            );
            $event_stream->addEvent($event);
        }

        return $event_stream;
    }


    /**
     * @param EventID|null $from_position
     *
     * @inheritDoc
     * @throws arException
     */
    public function getEventStream($from_position) : DomainEvents
    {
        $ar = EventStoreAR::where([]);
        /** @var EventStoreAR $from_event */
        $from_event = $from_position ? EventStoreAR::where(['event_id' => $from_position->getId()])->first() : null;
        if ($from_event) {
            $ar = $ar->where(
                ['id' => $from_event->getId()],
                ['id' => '>']
            );
        }
        $event_stream = new DomainEvents();
        foreach ($ar->orderBy('id', 'ASC')->get() as $item) {
            /** @var EventStoreAR $item */
            $event_class = $item->getEventClass();
            $event = $event_class::restore(
                $item->getEventId(),
                $item->getAggregateId(),
                $item->getInitiatingUserId(),
                $item->getOccurredOn(),
                $item->getEventBody()
            );
            $event_stream->addEvent($event);
        }

        return $event_stream;
    }
}