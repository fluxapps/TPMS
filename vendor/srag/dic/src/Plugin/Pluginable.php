<?php

namespace srag\DIC\TPMS\Plugin;

/**
 * Interface Pluginable
 *
 * @package srag\DIC\TPMS\Plugin
 */
interface Pluginable
{

    /**
     * @return PluginInterface
     */
    public function getPlugin() : PluginInterface;


    /**
     * @param PluginInterface $plugin
     *
     * @return static
     */
    public function withPlugin(PluginInterface $plugin)/*: static*/ ;
}
