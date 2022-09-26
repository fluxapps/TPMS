<?php

namespace srag\Plugins\TPMS\EventHandling\ValueObject;

use srag\CQRS\TPMS\Aggregate\AbstractValueObject;
use srag\Plugins\TPMS\Exception\TPMSException;

/**
 * Class LearningProgress
 *
 * @package srag\Plugins\TPMS\EventHandling\ValueObject
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LearningProgress extends AbstractValueObject
{
    const LP_STATUS_NOT_ATTEMPTED_NUM = 0;
    const LP_STATUS_IN_PROGRESS_NUM = 1;
    const LP_STATUS_COMPLETED_NUM = 2;
    const LP_STATUS_FAILED_NUM = 3;
    public static $available_status
        = [
            self::LP_STATUS_NOT_ATTEMPTED_NUM,
            self::LP_STATUS_IN_PROGRESS_NUM,
            self::LP_STATUS_COMPLETED_NUM,
            self::LP_STATUS_FAILED_NUM
        ];
    /**
     * @var int
     */
    protected $status;
    /**
     * @var int
     */
    protected $percentage;
    /**
     * @var int
     */
    protected $time_spent = 0;

    /**
     * @param int $status_id
     *
     * @return LearningProgress
     * @throws TPMSException
     */
    public static function createNew(int $status_id) : LearningProgress
    {
        if (!in_array($status_id, self::$available_status)) {
            throw new TPMSException('Invalid Learning Progress id: ' . $status_id);
        }
        $lp = new LearningProgress();
        $lp->status = $status_id;

        return $lp;
    }


    /**
     * @param int $percentage
     *
     * @return LearningProgress
     */
    public function withPercentage(int $percentage) : LearningProgress
    {
        $clone = clone $this;
        $clone->percentage = $percentage;

        return $clone;
    }


    /**
     * @param int $time_spent
     *
     * @return LearningProgress
     */
    public function withTimeSpent(int $time_spent) : LearningProgress
    {
        $clone = clone $this;
        $clone->time_spent = $time_spent;

        return $clone;
    }


    /**
     * @return int
     */
    public function getStatus() : int
    {
        return $this->status;
    }


    /**
     * @return int|null
     */
    public function getPercentage()
    {
        return $this->percentage;
    }


    /**
     * @return int
     */
    public function getTimeSpent() : int
    {
        return $this->time_spent;
    }


    /**
     * @return bool
     */
    public function hasPercentage() : bool
    {
        return !is_null($this->percentage) && is_numeric($this->percentage);
    }


    /**
     * @param AbstractValueObject $other
     *
     * @return bool
     */
    function equals(AbstractValueObject $other) : bool
    {
        return parent::equals($other);
    }


    /**
     * @return LearningProgress
     * @throws TPMSException
     */
    public static function notAttempted() : LearningProgress
    {
        return self::createNew(self::LP_STATUS_NOT_ATTEMPTED_NUM);
    }


    /**
     * @return LearningProgress
     * @throws TPMSException
     */
    public static function inProgress() : LearningProgress
    {
        return self::createNew(self::LP_STATUS_IN_PROGRESS_NUM);
    }


    /**
     * @return LearningProgress
     * @throws TPMSException
     */
    public static function completed() : LearningProgress
    {
        return self::createNew(self::LP_STATUS_COMPLETED_NUM);
    }


    /**
     * @return LearningProgress
     * @throws TPMSException
     */
    public static function failed() : LearningProgress
    {
        return self::createNew(self::LP_STATUS_FAILED_NUM);
    }
}