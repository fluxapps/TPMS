<?php

namespace srag\CQRS\TPMS\Projection\Persistence;

use ilDBInterface;
use srag\CQRS\TPMS\Projection\Persistence\ActiveRecord\LedgerAR;
use srag\CQRS\TPMS\Projection\PositionLedger;
use srag\CQRS\TPMS\Projection\Projector;
use srag\CQRS\TPMS\Projection\ValueObjects\ProjectorPosition;

/**
 * Class ilDBPositionLedger
 *
 * @author Theodor Truffer <tt@studer-raimann.ch>
 */
class ilDBPositionLedger implements PositionLedger
{

    /**
     * @var ilDBInterface
     */
    protected $database;


    /**
     * ilDBPositionLedger constructor.
     *
     * @param ilDBInterface $database
     */
    public function __construct(ilDBInterface $database)
    {
        $this->database = $database;
    }


    /**
     * @param ProjectorPosition $position
     */
    public function store(ProjectorPosition $position) : void
    {
        $ledger_ar = new LedgerAR();
        $ledger_ar->projector_class = get_class($position->projector);
        $ledger_ar->last_position = $position->last_position;
        $ledger_ar->processed_events = $position->processed_events;
        $ledger_ar->occurred_at = $position->occurred_at;
        $ledger_ar->status = $position->status;
        $ledger_ar->store();
    }


    /**
     * @param Projector $projector
     *
     * @return ProjectorPosition|null
     */
    public function fetch(Projector $projector) : ?ProjectorPosition
    {
        /** @var LedgerAR $ledger_ar */
        $ledger_ar = LedgerAR::find(get_class($projector));
        if (is_null($ledger_ar)) {
            return null;
        }

        return new ProjectorPosition(
            $projector,
            $ledger_ar->processed_events,
            $ledger_ar->occurred_at,
            $ledger_ar->last_position,
            $ledger_ar->status
        );
    }
}