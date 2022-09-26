<?php

namespace srag\Plugins\TPMS\EventHandling\Projection;

use srag\CQRS\TPMS\Projection\Projector;
use srag\Plugins\TPMS\EventHandling\Event\LearningProgressCourseUpdated;
use srag\Plugins\TPMS\EventHandling\ValueObject\LearningProgress;

/**
 * Class LearningProgressProjector
 *
 * @package srag\Plugins\TPMS\EventHandling\Projection
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LearningProgressProjector extends Projector
{

    /**
     * @var LearningProgressXMLProjection
     */
    protected $projection;

    /**
     * LearningProgressProjector constructor.
     *
     * @param LearningProgressXMLProjection $projection
     */
    public function __construct(LearningProgressXMLProjection $projection)
    {
        parent::__construct($projection);
    }


    /**
     * @param LearningProgressCourseUpdated $event
     */
    public function whenLearningProgressCourseUpdated(LearningProgressCourseUpdated $event)
    {
        if ($event->getLearningProgress()->getStatus() === LearningProgress::LP_STATUS_COMPLETED_NUM) {
            $this->projection->projectLearningProgress($event);
        }
    }
}