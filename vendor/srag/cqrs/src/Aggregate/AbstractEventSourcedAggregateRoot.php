<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\TPMS\Aggregate;

use srag\CQRS\TPMS\Event\DomainEvent;
use srag\CQRS\TPMS\Event\DomainEvents;

/**
 * Class AbstractEventSourcedAggregateRoot
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractEventSourcedAggregateRoot implements AggregateRoot, RecordsEvents, IsEventSourced {

	const APPLY_PREFIX = 'apply';
	/**
	 * @var DomainEvents
	 */
	private $recordedEvents;


    /**
     * AbstractEventSourcedAggregateRoot constructor.
     */
    protected function __construct() {
		$this->recordedEvents = new DomainEvents();
	}


    /**
     * @param DomainEvent $event
     */
    protected function ExecuteEvent(DomainEvent $event) {
		// apply results of event to class, most events should result in some changes
		$this->applyEvent($event);

		// always record that the event has happened
		$this->recordEvent($event);
	}


    /**
     * @param DomainEvent $event
     */
    protected function recordEvent(DomainEvent $event) {
		$this->recordedEvents->addEvent($event);
	}


    /**
     * @param DomainEvent $event
     */
    protected function applyEvent(DomainEvent $event) {
		$action_handler = $this->getHandlerName($event);

		if (method_exists($this, $action_handler)) {
			$this->$action_handler($event);
		}
	}


    /**
     * @param DomainEvent $event
     *
     * @return string
     */private function getHandlerName(DomainEvent $event) {
		return self::APPLY_PREFIX . join('', array_slice(explode('\\', get_class($event)), - 1));
	}


	/**
	 * @return DomainEvents
	 */
	public function getRecordedEvents(): DomainEvents {
		return $this->recordedEvents;
	}


    /**
     *
     */
    public function clearRecordedEvents()/*: void*/ {
		$this->recordedEvents = new DomainEvents();
	}


    /**
     * @return DomainObjectId
     */
    abstract function getAggregateId(): DomainObjectId;

    /**
     * @param DomainEvents $event_history
     *
     * @return AggregateRoot
     */
    public static function reconstitute(DomainEvents $event_history) : AggregateRoot
    {
        $aggregate_root = new static();
        foreach ($event_history->getEvents() as $event) {
            $aggregate_root->applyEvent($event);
        }

        return $aggregate_root;
    }
}