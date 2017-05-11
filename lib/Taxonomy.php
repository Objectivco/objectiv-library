<?php
/**
 * Class Taxonomy
 * 
 * Easily register taxonomies in Objectiv themes without a ton of arrays
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

class Taxonomy {

    /**
     * @var taxonomy
     */
    public $taxonomy;

    /**
     * @var singular
     */
    public $singular;

    /**
     * @var plural
     */
    public $plural;

    /**
     * @var slug
     */
    public $slug;
    
    /**
     * @var post_type
     */
    public $post_type;

    /**
     * @var args
     */
    public $args;

    /**
     * Construcotr
     *
     * @param string $taxonomy
     * @param string $post_type
     * @param array $args
     * 
     * @since 1.0
     */
    public function __construct( $taxonomy, $post_type, $args = null ) {
        $this->taxonomy = Inflector::slug( $taxonomy, '_' );
        $this->slug = Inflector::slug( $taxonomy, '_' );
        $this->singular = ucfirst( Inflector::singularize( $taxonomy) );
        $this->plural = ucfirst( Inflector::pluralize( $taxonomy ) );
        $this->post_type = $post_type;
        $this->labels = $this->build_labels();
        $this->args = $this->build_args();

        if ( $args ) {
            $this->args = array_replace_recursive( $this->args, $args );
        }

        var_dump($this->args);
    }

    /**
     * Init
     * 
     * @since 1.0
     */
    public function init() {
        add_action( 'init', array( $this, 'register' ) );
    }

    /**
     * Register
     * 
     * @since 1.0
     */
    public function register() {
        register_taxonomy( $this->taxonomy, $this->post_type, $this->args );
    }

    /**
     * Slugify
     *
     * @param string $name
     * @return string
     * 
     * @since 1.0
     */
    protected function slugify( $name ) {
        return str_replace( ' ', '_', strtolower( $name ) );
    }

    /**
     * Build labels
     *
     * @return array
     */
    protected function build_labels() {
        $labels = array(
            'name'  => __( $this->plural, 'objectiv' ),
            'singular_name' => __( $this->singular, 'objectiv' ),
            'menu_name' => __( $this->plural, 'objectiv' ),
            'all_items' => __( 'All ' . $this->plural, 'objectiv' ),
            'edit_item' => __( 'Edit ' . $this->singular, 'objectiv' ),
            'view_item' => __( 'View ' . $this->singular, 'objectiv' ),
            'update_item'   => __( 'Update ' . $this->singular, 'objectiv' ),
            'add_new_item'  => __( 'Add New ' . $this->singular, 'objectiv' ),
            'new_item_name' => __( 'New ' . $this->singular . ' Name', 'objectiv' ),
            'parent_item'   => __( 'Parent ' . $this->singular, 'objectiv' ),
            'search_items'  => __( 'Search ' . $this->plural . 'objectiv' ),
            'popular_items' => __( 'Popular ' . $this->plural . 'objectiv' ),
            'separate_items_with_commas'    => __( 'Separate ' . $this->plural . ' with commas', 'objectiv' ),
            'add_or_remove_items'   => __( 'Add or remove ' . $this->plural, 'objectiv' ),
            'choose_from_most_used' => __( 'Choose from the most used ' . $this->plural, 'objectiv' ),
            'not_found' => __( 'No ' . $this->plural . ' found', 'objectiv' )
        );

        return $labels;
    }

    /**
     * Build args
     * 
     * @return array
     * 
     * @since 1.0
     */
    protected function build_args() {
        $args = array(
            'labels' => $this->labels,
            'public'    => true,
            'publicly_queryable'    => true,
            'show_ui'   => true,
            'show_in_menu'  => true,
            'show_in_nav_menus' => true,
            'show_in_rest'  => true,
            'show_tagcloud' => false,
            'hierarchical'  => true,
            'rewrite'   => array(
                'slug'  => $this->slug
            )
        );

        return $args;
    }
}