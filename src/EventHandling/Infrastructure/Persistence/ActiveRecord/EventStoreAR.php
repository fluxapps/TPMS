<?php

namespace srag\Plugins\TPMS\EventHandling\Infrastructure\Persistence\ActiveRecord;

use srag\CQRS\TPMS\CQRS\Event\AbstractStoredEvent;

/**
 * Class EventStoreAR
 *
 * @package srag\Plugins\TPMS\EventHandling\Infrastructure\Persistence\ActiveRecord
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class EventStoreAR extends AbstractStoredEvent
{
    const TABLE_NAME = 'tpms_event';


    /**
     * @return string
     */
    public function getConnectorContainerName()
    {
        return self::TABLE_NAME;
    }
}