<?php
/**
 * Config Interface for Objectiv Settings
 * 
 * @package Objectiv
 * @author Wes Cole <wes@objectiv.co>
 * @license GPL-2.0+
 * @link http://objectiv.co
 * @copyright 2017 Objectiv
 */

namespace Objectiv;

/**
 * Interface ConfigInterface
 * 
 * Config for interjecting values into other classes
 * 
 * @package Objectiv
 * @author Wes Cole <wes@objectiv.co>
 * 
 * @since 1.0
 */
interface ConfigInterface {
    /**
     * Check to see if the Config has a specific key
     * 
     * @param string $key the key to check existence of
     * @return bool
     * 
     * @since 1.0
     */
    public function has_key( $key );

    /**
     * Get the value of a specific key
     * 
     * @param string $key the key to get the values of
     * @return mixed Value of the requested key
     * 
     * @since 1.0
     */
    public function get_key( $key );

    /**
     * Get an array of all the keys
     * 
     * @return array Array of config keys
     * 
     * @since 1.0
     */
    public function get_keys();
}