<?php

namespace srag\CustomInputGUIs\TPMS;

/**
 * Trait CustomInputGUIsTrait
 *
 * @package srag\CustomInputGUIs\TPMS
 */
trait CustomInputGUIsTrait
{

    /**
     * @return CustomInputGUIs
     */
    protected static final function customInputGUIs() : CustomInputGUIs
    {
        return CustomInputGUIs::getInstance();
    }
}
