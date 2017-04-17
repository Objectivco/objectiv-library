<?php
/**
 * Class View
 * 
 * Accepts a filename of PHP file and renders its content
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

class View {
    /**
     * File name of view
     * 
     * @var string
     * 
     * @since 1.0
     */
    protected $filename;

    /**
     * Instantiate the object
     * 
     * param string $filename
     * 
     * @since 1.0
     */
    public function __construct( $filename ) {
        $this->filename = $filename;
    }

    /**
     * Render the view
     * 
     * @param array $context Optional. Associative array with context
     * @return string HTML rendering of the view
     * 
     * @since 1.0
     */
    public function render( $context = array() ) {
        if ( ! is_readable( $this->filename ) )
            return '';

        ob_start();

        extract( $context );
        include $this->filename;

        return ob_get_clean();
    }

}