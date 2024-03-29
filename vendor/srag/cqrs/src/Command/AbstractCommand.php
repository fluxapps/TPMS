<?php
/* Copyright (c) 2019 - Martin Studer <ms@studer-raimann.ch> - Extended GPL, see LICENSE */

namespace srag\CQRS\TPMS\Command;

/**
 * Class AbstractCommand
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractCommand implements CommandContract {
	/**
	 * @var int
	 */
	protected $issuing_user_id;

	public function __construct(int $issuing_user_id) {
		$this->issuing_user_id = $issuing_user_id;
	}


    /**
     * @return int
     */
    public function getIssuingUserId() : int
    {
        return $this->issuing_user_id;
    }


}