<?php

namespace Objectiv;

use Objectiv\Admin as Admin;
use Objectiv\Settings as Settings;

/**
 * Objectiv Class
 * 
 * Main Objectiv class for the plugin
 */
class Objectiv {

    public static $version = '1.0.0';

    public function __construct() {

        if ( !defined('ABSPATH') ) {
			return;
		}

        // Start your engines!
        if ( class_exists( '\WP' ) ) {
            self::init();
        }   
    }

    public static function init() {
        new Admin();
        new Settings();
    }
}