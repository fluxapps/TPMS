<?php

namespace srag\Plugins\TPMS\EventHandling\Projection;

use ilDate;
use ilDBInterface;
use ilObjCourse;
use ilObject;
use ilObjUser;
use ilXmlWriter;
use srag\CQRS\TPMS\Projection\Projection;
use srag\Plugins\TPMS\EventHandling\Event\LearningProgressCourseUpdated;
use srag\Plugins\TPMS\EventHandling\ValueObject\LearningProgress;
use ilLearningProgress;
use ilDateTime;
use ilDateTimeException;

/**
 * Class LearningProgressProjection
 *
 * @package srag\Plugins\TPMS\EventHandling\Projection
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LearningProgressXMLProjection extends Projection
{

    const TAG_RECORD = 'Record';
    const TAG_LOGIN = 'LoginName';
    const TAG_FULL_NAME = 'Employee';
    const TAG_COURSE_REF_ID = 'CourseCode';
    const TAG_COURSE_TITLE = 'CourseTitle';
    const TAG_START_DATE = 'StartDate';
    const TAG_LP_STATUS = 'Status';
    const TAG_SCORE = 'Score';
    const TAG_COMPLETION_DATE = 'CompletionDate';
    const TAG_SPENT_SECONDS = 'TotalTime';
    const TAG_EXPIRY_DATE = 'ExpiryDate';

    const STATUS_MAP_COMPLETED = 'Pass';
    const STATUS_MAP_IN_PROGRESS = 'Incomplete';
    const STATUS_MAP_FAILED = 'Fail';

    const DATE_FORMAT = 'Y-m-d\TH:i:s\Z';

    /**
     * @var ilXMLWriter
     */
    private $xml_writer;


    /**
     * LearningProgressXMLProjection constructor.
     *
     * @param ilDBInterface $database
     * @param ilXMLWriter     $xml_writer
     */
    public function __construct(ilDBInterface $database, ilXMLWriter &$xml_writer)
    {
        parent::__construct($database);
        $this->xml_writer = $xml_writer;
    }

    /**
     * @param LearningProgressCourseUpdated $event
     * @throws ilDateTimeException
     */
    public function projectLearningProgress(LearningProgressCourseUpdated $event)
    {
        $references = ilObjCourse::_getAllReferences($event->getAggregateId()->getId());
        $ref_id = array_shift($references);
        $ilObjCourse = new ilObjCourse($ref_id);
        $ilObjUser = new ilObjUser($event->getUserId());
        $this->xml_writer->xmlStartTag(self::TAG_RECORD);

        $this->xml_writer->xmlElement(self::TAG_LOGIN, [], $ilObjUser->getLogin());
        $this->xml_writer->xmlElement(self::TAG_FULL_NAME, [], $ilObjUser->getFullname() . ' (' . $ilObjUser->getLogin() . ')');
        $this->xml_writer->xmlElement(self::TAG_COURSE_REF_ID, [], $ref_id);
        $this->xml_writer->xmlElement(self::TAG_COURSE_TITLE, [], $ilObjCourse->getTitle());

        $this->xml_writer->xmlElement(self::TAG_START_DATE, [], $this->getStartDate($ilObjCourse, $event));

        $status = $this->mapStatus($event->getLearningProgress()->getStatus());
        $this->xml_writer->xmlElement(self::TAG_LP_STATUS, [], $status);
        $this->xml_writer->xmlElement(
            self::TAG_COMPLETION_DATE,
            [],
            $status == self::STATUS_MAP_COMPLETED ? $event->getOccurredOn()->get(IL_CAL_FKT_DATE, self::DATE_FORMAT) : ''
        );
        $this->xml_writer->xmlElement(self::TAG_SPENT_SECONDS, [], $event->getLearningProgress()->getTimeSpent());
        // expiry date: now + 1 year
        $this->xml_writer->xmlElement(
            self::TAG_EXPIRY_DATE,
            [],
            trim((new ilDateTime(time() + 60*60*24*365, IL_CAL_UNIX))->get(IL_CAL_FKT_DATE, self::DATE_FORMAT))
        );

        $this->xml_writer->xmlElement(self::TAG_SCORE);

        $this->xml_writer->xmlEndTag(self::TAG_RECORD);
    }

    /**
     * @param ilObjCourse                   $ilObjCourse
     * @param LearningProgressCourseUpdated $event
     * @return string
     * @throws ilDateTimeException
     */
    protected function getStartDate(ilObjCourse $ilObjCourse, LearningProgressCourseUpdated $event) : string
    {
        /** @var ilDate $start */
        $start = $ilObjCourse->getCourseStart();
        if (is_null($start)) {
            $progress_array = ilLearningProgress::_getProgress($event->getUserId(), $ilObjCourse->getId());
            $start_unix = isset($progress_array['first_access']) ? $progress_array['first_access'] : time();
            $start = new ilDateTime($start_unix, IL_CAL_UNIX);
        }

        return $start->get(IL_CAL_FKT_DATE, self::DATE_FORMAT);
    }


    /**
     * @param int $status
     *
     * @return string
     */
    protected function mapStatus(int $status) : string
    {
    	switch ($status) {
            case LearningProgress::LP_STATUS_IN_PROGRESS_NUM:
            case LearningProgress::LP_STATUS_NOT_ATTEMPTED_NUM:
                return self::STATUS_MAP_IN_PROGRESS;
            case LearningProgress::LP_STATUS_FAILED_NUM:
                return self::STATUS_MAP_FAILED;
            case LearningProgress::LP_STATUS_COMPLETED_NUM:
                return self::STATUS_MAP_COMPLETED;
        }
    }
}
