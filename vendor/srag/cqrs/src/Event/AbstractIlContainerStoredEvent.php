<?php

namespace srag\CQRS\TPMS\Event;

use ActiveRecord;
use ilDateTime;
use ilException;
use srag\CQRS\TPMS\Aggregate\DomainObjectId;

/**
 * Class AbstractIlContainerStoredEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractIlContainerStoredEvent extends ActiveRecord
{

    /**
     * @var int
     *
     * @con_is_primary true
     * @con_is_unique  true
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_length     8
     * @con_sequence   true
     */
    protected $event_id;
    /**
     * @var string
     *
     * @con_has_field  true
     * @con_fieldtype  text
     * @con_length     200
     * @con_index      true
     * @con_is_notnull true
     */
    protected $aggregate_id;
    /**
     * @var string
     *
     * @con_has_field  true
     * @con_fieldtype  text
     * @con_length     200
     * @con_index      true
     * @con_is_notnull true
     */
    protected $event_name;
    /**
     * @var DomainObjectId
     *
     * @con_has_field  true
     * @con_fieldtype  timestamp
     * @con_index      true
     * @con_is_notnull true
     */
    protected $occurred_on;
    /**
     * @var int
     *
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_index      true
     * @con_is_notnull true
     */
    protected $container_obj_id;
    /**
     * @var int
     *
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_index      true
     * @con_is_notnull true
     */
    protected $initiating_user_id;
    /**
     * @var string
     *
     * @con_has_field  true
     * @con_fieldtype  clob
     * @con_is_notnull true
     */
    protected $event_body = '';


    /**
     * Store event data.
     *
     * @param DomainObjectId $aggregate_id
     * @param string         $event_name
     * @param ilDateTime     $occurred_on
     * @param int            $initiating_user_id
     * @param string         $event_body
     */
    public function setEventData(DomainObjectId $aggregate_id, string $event_name, ilDateTime $occurred_on, int $container_obj_id, int $initiating_user_id, string $event_body)
    {
        $this->aggregate_id = $aggregate_id;
        $this->event_name = $event_name;
        $this->occurred_on = $occurred_on;
        $this->container_obj_id = $container_obj_id;
        $this->initiating_user_id = $initiating_user_id;
        $this->event_body = $event_body;
    }


    /**
     * @return int
     */
    public function getEventId() : int
    {
        return $this->event_id;
    }


    /**
     * @return DomainObjectId
     */
    public function getAggregateId() : DomainObjectId
    {
        return $this->aggregate_id;
    }


    /**
     * @return string
     */
    public function getEventName() : string
    {
        return $this->event_name;
    }


    /**
     * @return ilDateTime
     */
    public function getOccurredOn() : ilDateTime
    {
        return $this->occurred_on;
    }


    /**
     * @return int
     */
    public function getContainerObjId() : int
    {
        return $this->container_obj_id;
    }


    /**
     * @return int
     */
    public function getInitiatingUserId() : int
    {
        return $this->initiating_user_id;
    }


    /**
     * @return string
     */
    public function getEventBody() : string
    {
        return $this->event_body;
    }


    /**
     * @param $field_name
     *
     * @return int|mixed|string|null
     */
    public function sleep($field_name)
    {
        switch ($field_name) {
            case 'occurred_on':
                return $this->occurred_on->get(IL_CAL_DATETIME);
            case 'aggregate_id':
                return $this->aggregate_id->getId();
            default:
                return null;
        }
    }


    /**
     * @param $field_name
     * @param $field_value
     *
     * @return ilDateTime|mixed|null
     * @throws ilDateTimeException
     */
    public function wakeUp($field_name, $field_value)
    {
        switch ($field_name) {
            case 'occurred_on':
                return new ilDateTime($field_value, IL_CAL_DATETIME);
            case 'aggregate_id':
                return new DomainObjectId($field_value);
            default:
                return null;
        }
    }


    //
    // CRUD
    //
    /**
     *
     */
    public function create()
    {
        parent::create();
    }


    //
    // Not supported CRUD-Options:
    //
    /**
     * @throws ilException
     */
    public function store()
    {
        throw new ilException("Store is not supported - It's only possible to add new records to this store!");
    }


    /**
     * @throws ilException
     */
    public function update()
    {
        throw new ilException("Update is not supported - It's only possible to add new records to this store!");
    }


    /**
     * @throws ilException
     */
    public function delete()
    {
        throw new ilException("Delete is not supported - It's only possible to add new records to this store!");
    }


    /**
     * @throws ilException
     */
    public function save()
    {
        throw new ilException("Save is not supported - It's only possible to add new records to this store!");
    }
}
