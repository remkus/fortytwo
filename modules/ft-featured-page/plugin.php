<?php
/*
Plugin Name: FortyTwo Featured Page Widget
Plugin URI: http://forsitethemes.com
Description: FortyTwo Featured Page Widget
Version: 1.0
Author: Forsite Themes
Author URI: http://forsitethemes.com
Author Email: mail@forsitethemes.com
Text Domain: ft-featured-page-locale
Domain Path: /lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2013 mail@forsitethemes.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class FT_Featured_Page extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * Specifies the classname and description, instantiates the widget, 
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
	
		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );
		
		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		parent::__construct(
			'ft-featured-page',
			__( 'FortyTwo - Featured Page', 'ft-featured-page-locale' ),
			array(
				'classname'		=>	'ft-featured-page',
				'description'	=>	__( 'Featured Page widget for the FortyTwo Theme.', 'ft-featured-page-locale' )
			)
		);
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
        //add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
        //add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
		
	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {
	
		extract( $args, EXTR_SKIP );
		
		echo $before_widget;
    
    foreach (array('title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name) {
			$$field_name = apply_filters( 'widget_$field_name', $instance[ $field_name ] );
		}
		if ( empty( $title ) ) $title  = "The title";
		if ( empty( $icon ) ) $icon  = "icon-star";
		if ( empty( $content ) ) $content  = "And purely one near this hey therefore darn firefly had ducked overpaid wow irrespective some tearful and mandrill
    yikes considering far above. Physically less snickered much and and while";
		if ( empty( $button_text ) ) $button_text  = "Click me!";
		if ( empty( $button_link ) ) $button_link  = "#";
		
		include( dirname( __FILE__ )  . '/views/widget.php' );
		
		echo $after_widget;
		
	} // end widget
	
	public function echo_field_id($field) {
		echo ' id="'.$this->get_field_id( $field ). '" name="' .$this->get_field_name( $field ) . '" ';
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	old_instance	The previous instance of values before the update.
	 * @param	array	new_instance	The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		foreach (array('title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name) {
			$instance[$field_name] = ( !empty( $new_instance[$field_name] ) ) ? strip_tags( $new_instance[$field_name] ) : '';
		}

		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

    	// Default values for variables
		$instance = wp_parse_args(
			(array) $instance,
            array(
                'title' => '',
                'icon' => '',
                'content' => '',
                'button_text' => '',
                'button_link' => ''
            )
		);

		// Set $template_var to instance[$template_var]
		foreach (array('title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name) {
			$$field_name = $instance[ $field_name ];
		}
		
		// Display the admin form
		include( dirname (__FILE__) . '/views/admin.php' );	
		
	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/
	
	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
	
		load_plugin_textdomain( 'ft-featured-page-locale', false, dirname( __FILE__ ) . '/lang/' );
		
	} // end widget_textdomain
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param		boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here		
	} // end deactivate
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		wp_enqueue_style( 'ft-featured-page-admin-styles', modules_url( 'ft-featured-page/css/admin.css' ) );
		wp_enqueue_style( 'fontawesome_icon_selector_app', modules_url( 'ft-featured-page/css/fontawesome_icon_selector_app.css' ) );
			
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
	  wp_enqueue_script( 'backbone' );
		wp_enqueue_script( 'fontawesome_icon_selector_app', modules_url( 'ft-featured-page/js/fontawesome_icon_selector_app.js' ), array( 'backbone' ) );
		wp_enqueue_script( 'ft-featured-page-admin-script', modules_url( 'ft-featured-page/js/admin.js' ),  array( 'fontawesome_icon_selector_app' ) );
		
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
	
		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_style( 'ft-featured-page-widget-styles', modules_url( 'ft-featured-page/css/widget.css' ) );
		
	} // end register_widget_styles
	
	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
	
		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_script( 'ft-featured-page-script', modules_url( 'ft-featured-page/js/widget.js' ) );
		
	} // end register_widget_scripts
	
} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Featured_Page");' ) );