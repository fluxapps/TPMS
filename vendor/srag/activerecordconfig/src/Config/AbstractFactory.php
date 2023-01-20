<?php

namespace srag\ActiveRecordConfig\TPMS\Config;

use srag\DIC\TPMS\DICTrait;

/**
 * Class AbstractFactory
 *
 * @package srag\ActiveRecordConfig\TPMS\Config
 */
abstract class AbstractFactory
{

    use DICTrait;

    /**
     * AbstractFactory constructor
     */
    protected function __construct()
    {

    }


    /**
     * @return Config
     */
    public function newInstance() : Config
    {
        $config = new Config();

        return $config;
    }
}
