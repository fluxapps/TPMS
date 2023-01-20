<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\TPMS\Aggregate;

/**
 * Interface AggregateRoot
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author Adrian Lüthi <al@studer-raimann.ch>
 * @author Björn Heyser <bh@bjoernheyser.de>
 * @author Martin Studer <ms@studer-raimann.ch>
 * @author Theodor Truffer <tt@studer-raimann.ch>
 */
interface AggregateRoot {

    /**
     * @return DomainObjectId
     */
	public function getAggregateId(): DomainObjectId;
}