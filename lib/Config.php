<?php
/**
 * Class Config
 * 
 * @package Objectiv
 * @author Wes Cole <wes@objectiv.co>
 * @license GPL-2.0+
 * @link http://objectiv.co
 * @copyright 2017 Objectiv
 * 
 * @since 1.0
 */

namespace Objectiv;

use ArrayObject;
use Exception;
use RuntimeException;

class Config extends ArrayObject implements ConfigInterface {
    /**
     * Instantate the class object
     * 
     * @param array|string $config array with settings or string with path to config file
     * 
     * @since 1.0
     */
    public function __construct( $config ) {
        // Check if it is a string, if so assume it is path to Config file
        if ( is_string( $config ) ) {
            $config = $this->load_uri( $config ) ?: [];
        }

        // Turn config object into an array
        parent::__construct( $config, ArrayObject::ARRAY_AS_PROPS );
    }

    /**
     * Check to see if config has key
     * 
     * @param string $key the key we are checking for
     * @return bool
     * 
     * @since 1.0
     */
    public function has_key( $key ) {
        return array_key_exists( $key, (array) $this );
    }

    /**
     * Get the value of a specific key
     * 
     * @param string $key the key we are getting the value for
     * @return mixed Value of the key
     * 
     * @since 1.0
     */
    public function get_key( $key ) {
        return $this[$key];
    }

    /**
     * Get an array with all of the keys
     * 
     * @return array Array of all keys
     * 
     * @since 1.0
     */
    public function get_keys() {
        return array_keys( (array) $this );
    }

    /**
     * Load the contents of the config file
     * 
     * @param string $uri URI of the config file
     * @return array|null Raw data from the file, null if nothing found
     * @throws RuntimeException If the resource can't be found
     * 
     * @since 1.0
     */
    protected function load_uri( $uri ) {
        try {
            // try to load the file
            ob_start();
            $data = include( $uri );
            ob_end_clean();
            return (array) $data;
        } catch( Exception $exception ) {
            throw new RuntimeException(
                sprintf(
                    'Could not include PHP config file "%1$s". Reason: "%2$s".',
                    $uri,
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        }
    }
}