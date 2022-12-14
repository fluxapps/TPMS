<?php

namespace srag\Plugins\TPMS\Config;

use srag\Plugins\TPMS\Utils\TPMSTrait;
use ilTPMSConfigGUI;
use ilTPMSPlugin;
use ilTextInputGUI;
use srag\ActiveRecordConfig\TPMS\Config\Config;
use srag\CustomInputGUIs\TPMS\PropertyFormGUI\PropertyFormGUI;

/**
 * Class ConfigFormGUI
 *
 * Generated by SrPluginGenerator v1.3.5
 *
 * @package srag\Plugins\TPMS\Config
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends PropertyFormGUI
{

    use TPMSTrait;
    const PLUGIN_CLASS_NAME = ilTPMSPlugin::class;
    const KEY_URL = "url";
    const LANG_MODULE = ilTPMSConfigGUI::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ilTPMSConfigGUI $parent
     */
    public function __construct(ilTPMSConfigGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            default:
                return self::TPMS()->config()->getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ilTPMSConfigGUI::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_URL => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ]
        ];
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt("configuration"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                self::TPMS()->config()->setValue($key, $value);
                break;
        }
    }
}
