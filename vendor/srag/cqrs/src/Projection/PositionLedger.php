<?php

namespace srag\CQRS\TPMS\Projection;

use srag\CQRS\TPMS\Projection\ValueObjects\ProjectorPosition;

/**
 * Class PositionLedger
 *
 * @package srag\CQRS\TPMS\Projection
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
interface PositionLedger
{

    public function store(ProjectorPosition $position)/* : void*/;


    public function fetch(Projector $projector)/* : ?ProjectorPosition*/;
}