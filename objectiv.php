<?php

/**
 * Bootstrap file for the library
 * 
 * @link objectiv.co
 * @since 1.0
 * @package Objectiv
 * 
 * @wordpress-plugin
 * Plugin Name: Objectiv Library
 * Plugin URI: http://objectiv.co
 * Description: Objectiv's WordPress library for working with Timber and Advanced Custom Fields.
 * Version: 1.0.0
 * Author: Wes Cole + Objectiv
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: objectiv
 * Domain Path: /languages
 */

// If file is called directly, abort.
if ( ! defined( 'WPINC' ) )
    die;

require_once "vendor/autoload.php";

new \Objectiv\Objectiv;