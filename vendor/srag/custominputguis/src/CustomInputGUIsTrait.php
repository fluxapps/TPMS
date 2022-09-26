<?php

namespace srag\CustomInputGUIs\TPMS;

/**
 * Trait CustomInputGUIsTrait
 *
 * @package srag\CustomInputGUIs\TPMS
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait CustomInputGUIsTrait
{

    /**
     * @return CustomInputGUIs
     */
    protected static final function customInputGUIs()
    {
        return CustomInputGUIs::getInstance();
    }
}
