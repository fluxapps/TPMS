<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\TPMS\Event;

use srag\CQRS\TPMS\Aggregate\DomainObjectId;

/**
 * Interface EventStore
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
interface EventStore {

	/**
	 * @param DomainEvents $events
	 */
	public function commit(DomainEvents $events);


	/**
	 * @param DomainObjectId $id
	 *
	 * @return DomainEvents
	 */
	public function getAggregateHistoryFor(DomainObjectId $id): DomainEvents;


    /**
     * @param EventID $from_position
     *
     * @return DomainEvents
     */
	public function getEventStream(?EventID $from_position) : DomainEvents;
}