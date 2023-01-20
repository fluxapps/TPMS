<?php

namespace srag\CQRS\TPMS\Event;

use srag\CQRS\TPMS\Aggregate\Guid;

/**
 * Class EventID
 *
 * @package srag\CQRS\TPMS\Event
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class EventID
{

    /**
     * @var string
     */
    private $id;


    /**
     * DomainObjectId constructor.
     *
     * @param string|null $id
     *
     * @throws \Exception
     */
    public function __construct(string $id = null)
    {
        $this->id = $id ?: Guid::create();
    }


    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }


    /**
     * @param EventID $anId
     *
     * @return bool
     */
    public function equals(EventID $anId) : bool
    {
        return $this->getId() === $anId->getId();
    }
}