<?php
/**
 * Class Settings
 * 
 * This class registers a settings page via the WordPress Settings API.
 *
 * It enables you an entire collection of settings pages and options fields as
 * as hierarchical text representation in your Config file. In this way, you
 * don't have to deal with all the confusing callback code that the WordPress
 * Settings API forces you to use.
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

class Settings {

    use FunctionInvokerTrait;

    /**
     * Keys for different config sections
     * 
     * @since 1.0
     */
    const CONFIG_KEY_PAGES = 'pages';
    const CONFIG_KEY_SETTINGS = 'settings';

    /**
     * Config instance
     * 
     * @var ConfigInterface
     * 
     * @since 1.0
     */
    protected $config;

    /**
     * Hooks to the settings page that have been registered
     * 
     * @var array
     * 
     * @since 1.0
     */
    protected $page_hooks = [];

    /**
     * Array of allowed tags for escaping
     * 
     * @var array
     * 
     * @since 1.0
     */
    protected $allowed_tags = [];

    /**
     * Instantiate the object
     * 
     * @param ConfigInterface $config Config object that contains the settings
     * @param array|null $allowed_tags Optional.
     * 
     * @since 1.0
     */
    public function __construct( ConfigInterface $config, array $allowed_tags = null ) {
        global $allowedposttags;
        $this->config = $config;
        $this->allowed_tags = null === $allowed_tags
            ? $this->prepare_allowed_tags( $allowedposttags )
            : $allowed_tags;
    }

    /**
     * Prepare an array of allowed tags
     * 
     * @param array $allowed_tags Allowed tags from WP defaults
     * @return array Modified tags array
     * 
     * @since 1.0
     */
    protected function prepare_allowed_tags( $allowed_tags ) {
        $form_tags = array(
            'form'  => array(
                'id'    => true,
                'class' => true,
                'action'    => true,
                'method'    => true
            ),
            'input' => array(
                'id'    => true,
                'class' => true,
                'type'  => true,
                'name'  => true,
                'value' => true
            )
        );
        return array_replace_recursive( $allowed_tags, $form_tags );
    }

    /**
     * Register hooks for settings page
     * 
     * @since 1.0
     */
    public function register() {
        add_action( 'admin_menu', array( $this, 'add_pages' ) );
        // add_action( 'admin_init', array( $this, 'init_settings' ) );
    }

    /**
     * Add pages from the config settings
     * 
     * @since 1.0
     */
    public function add_pages() {
        $this->iterate( static::CONFIG_KEY_PAGES );
    }

    /**
     * Iterate over collection of config settings
     * 
     * @param string $type Type of entries to iterate over
     * 
     * @since 1.0
     */
    protected function iterate( $type ) {
        if ( ! $this->config->has_key( "${type}" ) )
            return;

        $entries = $this->config->get_key( "${type}" );
        array_walk( $entries, array( $this, "add_${type}_entry" ) );
    }

    /**
     * Add a single page to the WP admin
     * 
     * @param array $data Arguments for page creation
     * @param string $name Current page name
     * @throws InvalidArgumentException 
     * 
     * @since 1.0
     */
    protected function add_pages_entry( $data, $name ) {
        // Only create page if it doesn't exist
        if ( ! empty( $GLOBALS['admin_page_hooks'][$name] ) )
            return;

        // If parent slug, add submenu page
        $function = array_key_exists( 'parent_slug', $data ) ? 'add_submenu_page' : 'add_menu_page';

        // Add page name
        $data['menu_slug'] = $name;

        $data['function'] = function() use ( $data ) {
            if ( ! array_key_exists( 'view', $data ) )
                return;

            $this->render_view( $data['view'] );
        };

        $page_hook = $this->invoke_function( $function, $data );
        $this->page_hooks[] = $page_hook;
    }

    /**
     * Render specified view
     * 
     * @param string|View $view View to render. Can be a path or instance to object
     * @param array|null $context Optional. Context to render the view
     * 
     * @since 1.0
     */
    protected function render_view( $view, array $context = array() ) {
        $view_object = is_string( $view ) ? new View( $view ) : $view;
        echo wp_kses(
            $view_object->render( $context ),
            $this->allowed_tags
        );
    }
}