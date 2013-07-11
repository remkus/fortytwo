<?php
/*
Description: FortyTwo Testimonials Widget
Author: Forsite Themes
Author URI: http://forsitethemes.com
Author Email: mail@forsitethemes.com
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

class FT_Testimonials extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * Specifies the classname and description, instantiates the widget, 
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
		
		parent::__construct(
			'widget-ft-testimonials',
			__( 'FortyTwo - Testimonials', 'ft-testimonials-locale' ),
			array(
				'classname'		=>	'ft-testimonials',
				'description'	=>	__( 'Testimonials widget for the FortyTwo Theme.', 'ft-testimonials-locale' )
			)
		);
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
        //add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
        //add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
		
	} // end constructor

	private function url($file) {
		return FORTYTWO_WIDGETS_URL.'/ft-testimonials'.$file;
	}

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
      
		include( plugin_dir_path( __FILE__ ) . '/views/widget.php' );
		
		echo $after_widget;
		
	} // end widget
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The previous instance of values before the update.
	 * @param	array	old_instance	The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		// TODO:	Here is where you update your widget's old values with the new, incoming values
    
		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {
	
  	$instance = wp_parse_args(
			(array) $instance,
            array(
                'foo' => '',
                'bar' => ''
            )
		);
	
		// TODO:	Store the values of the widget in their own variable
		
		// Display the admin form
		include( plugin_dir_path(__FILE__) . '/views/form.php' );	
		
	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		// TODO:	Change 'widget-name' to the name of your plugin
    wp_enqueue_style( 'ft-testimonials-admin-styles',  $this->url( '/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		wp_enqueue_script( 'ft-testimonials-admin-script', $this->url( '/js/admin.js' ) );
		
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
	
		wp_enqueue_style( 'ft-testimonials-widget-styles', $this->url( '/css/widget.css' ) );
		
	} // end register_widget_styles
	
	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
	
		wp_enqueue_script( 'ft-testimonials-script', $this->url( '/js/widget.js' ) );
		
	} // end register_widget_scripts
	
} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Testimonials");' ) );