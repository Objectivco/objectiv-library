<?php
/**
 * Objectiv Settings
 *
 * @package Objectiv\Settings
 * @author  Objectiv
 * @license GPL-2.0+
 * @link    http://objectiv.co
 */

namespace Objectiv;

class Settings {
    private $settings;
    public $prefix = 'objectiv';

    public function __construct() {
        add_action( 'init', array( $this, 'load_settings' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Store all settings in an array
     *
     * @return array of settings
     * 
     * @since 1.0
     */
    public function settings_fields() {
        $settings = array();

        $settings['general'] = array(
            'title' => __( 'General Options', 'objectiv' ),
            'description'   => __( 'Description', 'objectiv' ),
            'fields'    => array(
                array(
                    'id'    => 'site_title',
                    'label' => __( 'Site Title', 'objectiv' ),
                    'description'   => __( 'Enter the site title.', 'objectiv' ),
                    'type'  => 'text',
                    'default'   => get_bloginfo( 'name' ),
                    'placeholder'   => get_bloginfo( 'name' ),
                    'callback'  => ''
                )
            )
        );

        $settings = apply_filters( 'objectiv_settings', $settings );
        return $settings;
    }

    /**
     * Load Settings
     * 
     * @since 1.0
     */
    public function load_settings() {
        $this->settings = $this->settings_fields();
    }

    /**
     * Register Settings
     * 
     * @since 1.0
     */
    public function register_settings() {
        if ( is_array( $this->settings ) ) {
            foreach ( $this->settings[0] as $section => $data ) {
                $section_title = $data['title'];
                add_settings_section( $section, $section_title, array( $this, 'settings_section' ), 'objectiv_settings' );

                foreach( $data['fields'] as $field ) {
                    register_setting( 'objectiv_settings', 'objectiv_settings_' . $field['id']);
                    add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'objectiv_settings', $section, array( 'field' => $field, 'prefix' => 'objectiv_settings_' ) );
                }
            }
        }
    }

    /**
     * Display Settings Section
     * 
     * @since 1.0
     */
    public function settings_section( $section ) {
        $html = '<p>' . $this->settings[$section['id']]['description'] . '</p>';
        echo $html;
    }

    /**
     * Display Field
     * 
     * @since 1.0
     */
    public function display_field( $args ) {
        $field = $args['field'];
        $html = '';
        $option_name = 'objectiv_settings_' . $field['id'];
        
        // Get the default for the field
        $default = '';
        if ( isset( $field['default'] ) ) {
            $default = $field['default'];
        }
        
        // Get the value for the field
        $value = get_option( $option_name, $default );
        
        switch( $field['type'] ) {
            case 'text':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $value ) . '" class="large-text"/><span class="description">' . $field['description'] . '</span>' . "\n";
            break;
            case 'textarea':
				$html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" class="large-text">' . $value . '</textarea><br/><span class="description">' . $field['description'] . '</span>'. "\n";
			break;
            case 'checkbox':
				$checked = '';
				if ( $value && 'on' == $value ){
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . ' class="' . $class . '"/><span class="description">' . wp_kses_post( $field['description'] ) . '</span>' . "\n";
			break;
            case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				$prev_group = '';
				foreach ( $field['options'] as $k => $v ) {
					$group = '';
					if ( is_array( $v ) ) {
						if ( isset( $v['group'] ) ) {
							$group = $v['group'];
						}
						$v = $v['label'];
					}
					if ( $prev_group && $group != $prev_group ) {
						$html .= '</optgroup>';
					}
					$selected = false;
					if ( $k == $value ) {
						$selected = true;
					}
					if ( $group && $group != $prev_group ) {
						$html .= '<optgroup label="' . esc_attr( $group ) . '">';
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . esc_html( $v ) . '</option>';
					$prev_group = $group;
				}
				$html .= '</select>';
			break;
            case 'image':
				$html .= '<img id="' . esc_attr( $option_name ) . '_preview" src="' . esc_attr( $value ) . '" style="max-width:400px;height:auto;" /><br/>' . "\n";
				$html .= '<input id="' . esc_attr( $option_name ) . '_button" type="button" class="button" value="'. __( 'Upload new image' , 'pl-sermons' ) . '" />' . "\n";
				$html .= '<input id="' . esc_attr( $option_name ) . '_delete" type="button" class="button" value="'. __( 'Remove image' , 'pl-sermons' ) . '" />' . "\n";
				$html .= '<input id="' . esc_attr( $option_name ) . '" type="hidden" name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $value ) . '"/><br/>' . "\n";
			break;
            case 'radio':
                $html .= '<span class="description">' . $field['description'] . '</span>';
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
                    $checked_class = '';
					if ( $k == $value ) {
						$checked = true;
                        $checked_class = 'selected';
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '" class="radio-image ' . $checked_class . '"><span class="screen-reader-text">' . $v . '</span><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" class="screen-reader-text" /><img src="' . plugins_url( '/assets/images/' . $k . '.png', $this->file ) . '" /></label>';
				}
			break;
        }
        echo $html;
    }
}