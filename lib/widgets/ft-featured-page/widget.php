<?php
/*

Description: FortyTwo Featured Page Widget
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

class FT_Featured_Page extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'ft-featured-page',
			__( 'FortyTwo - Featured Page', 'fortytwo' ),
			array(
				'classname'  => 'ft-featured-page',
				'description' => __( 'Featured Page widget for the FortyTwo Theme.', 'fortytwo' )
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
	 * @param array   args  The array of form elements
	 * @param array   instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		foreach ( array( 'title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name ) {
			$instance[$field_name] = apply_filters( 'widget_$field_name', $instance[ $field_name ] );
		}
		$this->set_default( $instance['title'], __( "The title", 'fortytwo' ) );
		$this->set_default( $instance['icon '], "icon-star" );
		$this->set_default( $instance['content'], __( "And purely one near this hey therefore darn firefly had ducked overpaid wow irrespective some tearful and mandrill
    yikes considering far above. Physically less snickered much and and while", 'fortytwo' ) );
		$this->set_default( $instance['button_text'], __( "Click me!", 'fortytwo' ) );
		$this->set_default( $instance['button_link'], "#" );

		include dirname( __FILE__ )  . '/views/widget.php';

		echo $after_widget;

	} // end widget

	private function set_default( &$value, $default ) {
		if ( empty ( $value ) ) $value = $default;
	}

	public function echo_field_id( $field ) {
		echo ' id="'.$this->get_field_id( $field ). '" name="' .$this->get_field_name( $field ) . '" ';
	}

	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL.'/ft-featured-page'.$file;
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array   old_instance The previous instance of values before the update.
	 * @param array   new_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		foreach ( array( 'title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name ) {
			$instance[$field_name] = ( !empty( $new_instance[$field_name] ) ) ? strip_tags( $new_instance[$field_name] ) : '';
		}

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array   instance The array of keys and values for the widget.
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

		// Display the admin form
		include dirname( __FILE__ ) . '/views/form.php';

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( 'ft-featured-page-admin-styles', $this->url( '/css/admin.css' ) );
		wp_enqueue_style( 'font-awesome-more', FORTYTWO_URL . '/vendor/frameworks/font-awesome-more/css/font-awesome.min.css' );
		wp_enqueue_style( 'fontawesome_icon_selector_app', $this->url( '/css/fontawesome_icon_selector_app.css' ), array( 'font-awesome-more' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'jquery-effects-slide' );
		wp_enqueue_script( 'backbone' );
		wp_enqueue_script( 'fontawesome_icon_selector_app', $this->url( '/js/fontawesome_icon_selector_app.js' ), array( 'backbone' ) );
		wp_enqueue_script( 'ft-featured-page-admin-script', $this->url( '/js/admin.js' ),  array( 'fontawesome_icon_selector_app' ) );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( 'ft-featured-page-widget-styles', $this->url( '/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( 'ft-featured-page-script', $this->url( '/js/widget.js' ) );

	} // end register_widget_scripts

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Featured_Page");' ) );
