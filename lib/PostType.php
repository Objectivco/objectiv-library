<?php
/**
 * Class PostType
 * 
 * Easily register post types in Objectiv themes without a ton of arrays
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

use Objectiv\Inflector as Inflector;

class PostType {

    /**
     * @var name
     */
    public $name;

    /**
     * @var slug
     */
    public $slug;

    /**
     * @var singular
     */
    public $singular;

    /**
     * @var plural
     */
    public $plural;

    /**
     * @var args
     */
    public $args;

    /**
     * @var labels
     */
    public $labels;

    public function __construct( $name, $args = null ) {
        $this->name = $name;
        $this->plural = $this->pluralize( $this->name );
        $this->slug = $this->slugify( $this->name );
        $this->labels = $this->build_labels();
        $this->args = $this->build_args();

        if ( $args ) {
            $this->args = array_replace_recursive( $this->args, $args );
        }

        $this->init();
    }

    /**
     * Initialize everything
     *
     * @since 1.0
     */
    protected function init() {
        add_action( 'init', array( $this, 'register_posttype' ) );
    }

    /**
     * Register post type
     * 
     * @since 1.0
     */
    public function register_posttype() {
        register_post_type( $this->name, $this->args );
    }

    /**
     * Create slug
     * 
     * @since 1.0
     */
    public function slugify( $name ) {
        return str_replace( ' ', '-', strtolower( $name ) );
    }

    /**
     * Pluralize the name
     * 
     * @since 1.0
     */
    public function pluralize( $name ) {
        return Inflector::pluralize( $name );
    }

    /**
     * Build Labels
     *
     * @return array
     * 
     * @since 1.0
     */
    protected function build_labels() {
        $labels = array(
            'name'  => __( $this->plural, 'objectiv' ),
            'singular_name' => __( $this->name, 'objectiv' ),
            'add_new' => __( 'Add New', 'objectiv' ),
            'add_new_item'  => __( 'Add New ' . $this->name, 'objectiv' ),
            'edit_item' => __( 'Edit ' . $this->name, 'objectiv' ),
            'new_item'  => __( 'New ' . $this->name, 'objectiv' ),
            'view_item' => __( 'View ' . $this->name, 'objectiv' ),
            'view_items'    => __( 'View ' . $this->plural, 'objectiv' ),
            'search_items'  => __( 'Search ' . $this->plural, 'objectiv' ),
            'not_found' => __( 'No ' . $this->plural . ' found', 'objectiv' ),
            'not_found_in_trash'    => __( 'No ' . $this->plural . ' found in trash', 'objectiv' ),
            'parent_item_colon' => __( 'Parent ' . $this->name . ':', 'objectiv' ),
            'all_items' => __( 'All ' . $this->plural, 'objectiv' ),
            'archives'  => __( $this->plural . ' Archives', 'objectiv' ),
            'attributes'    => __( $this->name . ' Attributes', 'objectiv' ),
            'insert_into_item'  => __( 'Insert into ' . $this->name ),
            'uploaded_to_this_item' => __( 'Uploaded to this ' . $this->name, 'objectiv' ),
            'menu_name' => __( $this->plural, 'objectiv' ),
            'filter_items_list' => __( 'Filter ' . $this->plural . ' list', 'objectiv' ),
            'items_list'    => __( $this->plural . ' list', 'objectiv' ),
            'name_admin_bar'    => __( $this->plural, 'objectiv' )
        );

        return $labels;
    }

    /**
     * Build Arguments
     * 
     * @return array
     * 
     * @since 1.0
     */
    public function build_args() {
        $args = array(
            'labels' => $this->labels,
            'public' => true,
            'exclude_search'    => false,
            'publicly_queryable'    => true,
            'show_ui'   => true,
            'show_in_nav_menus' => true,
            'show_in_menu'  => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'rewrite' => array(
                'slug' => $this->slug,
            ),
            'show_in_rest'  => true
        );

        return $args;
    }
}