<?php

namespace srag\Plugins\TPMS\EventHandling\Event;

use ilDateTime;
use ilDateTimeException;
use srag\CQRS\TPMS\Aggregate\DomainObjectId;
use srag\CQRS\TPMS\Event\AbstractDomainEvent;
use srag\Plugins\TPMS\EventHandling\ValueObject\LearningProgress;

/**
 * Class LearningProgressCourseUpdated
 *
 * @package srag\Plugins\TPMS\EventHandling\Event
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LearningProgressCourseUpdated extends AbstractDomainEvent
{

    const NAME = 'LearningProgressCourseUpdated';
    /**
     * @var int
     */
    protected $user_id;
    /**
     * @var LearningProgress
     */
    protected $learning_progress;


    /**
     * @param DomainObjectId   $aggregate_id
     * @param int              $user_id
     *
     * @param LearningProgress $learning_progress
     * @param int              $issuing_user_id
     *
     * @return static
     * @throws ilDateTimeException
     */
    public static function createNew(DomainObjectId $aggregate_id, int $user_id, LearningProgress $learning_progress, int $issuing_user_id) : self
    {
        $new = new self($aggregate_id, (new ilDateTime(time(), IL_CAL_UNIX)), $issuing_user_id);
        $new->user_id = $user_id;
        $new->learning_progress = $learning_progress;

        return $new;
    }


    /**
     * @inheritDoc
     */
    public function getEventName() : string
    {
        return self::NAME;
    }


    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }


    /**
     * @return LearningProgress
     */
    public function getLearningProgress() : LearningProgress
    {
        return $this->learning_progress;
    }


    /**
     * @inheritDoc
     */
    public function getEventBody() : string
    {
        return json_encode([
            'user_id' => $this->user_id,
            'learning_progress' => $this->learning_progress
        ]);
    }


    /**
     * @inheritDoc
     */
    protected function restoreEventBody(string $event_body)
    {
        $body = json_decode($event_body);
        $this->user_id = $body->user_id;
        $this->learning_progress = LearningProgress::jsonDeserialize($body->learning_progress);
    }
}