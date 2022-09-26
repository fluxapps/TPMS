<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\TPMS\Aggregate;

use srag\CQRS\TPMS\Event\DomainEvents;

/**
 * An AggregateRoot, that can be reconstituted from an AggregateHistory.
 */
interface IsEventSourced {

    /**
     * @param DomainEvents $event_history
     *
     * @return AggregateRoot
     */
	public static function reconstitute(DomainEvents $event_history): AggregateRoot;
}
 