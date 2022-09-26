<?php

namespace srag\CQRS\TPMS\Projection\ValueObjects;

/**
 * Class ProjectorMode
 *
 * @package srag\CQRS\TPMS\Projection\ValueObjects
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ProjectorMode
{

    const RUN_ONCE = 'run_once';
    const RUN_FROM_START = 'run_from_start';
    const RUN_FROM_LAUNCH = 'run_from_launch';
}