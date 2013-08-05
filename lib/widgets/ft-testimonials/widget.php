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

//Required for use of is_plugin_active() - http://codex.wordpress.org/Function_Reference/is_plugin_active#Usage
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 

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
			__( 'FortyTwo - Testimonials', 'fortytwo' ),
			array(
				'classname'  => 'ft-testimonials',
				'description' => __( 'Testimonials widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

	} // end constructor

	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL.'/ft-testimonials'.$file;
	}

	public function echo_field_id( $field ) {
		echo ' id="'.$this->get_field_id( $field ). '" name="' .$this->get_field_name( $field ) . '" ';
	}

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

		foreach ( array( 'title', 'limit', 'datasource', 'category' ) as $field_name ) {
			$instance[$field_name] = apply_filters( 'widget_$field_name', $instance[ $field_name ] );
		}
		$this->set_default( $instance['title'], __( "Client Testimonials", 'fortytwo' ) );
		$this->set_default( $instance['limit'], 5 );
		$this->set_default( $instance['datasource'], 'category' );
		$this->set_default( $instance['category'], 1 );
		$this->set_default( $instance['testimonials'], array() );

		switch ( $instance['datasource'] ) {
		case "testimonials-by-woothemes":
			if (!$this->is_testimonials_by_woothemes_installed()) break;
			$posts = woothemes_get_testimonials( array(
					'limit' => $instance['limit'],
					'orderby' => 'menu_order',
					'order' => 'DESC',
					'display_author' => true,
					'display_avatar' => true,
					'display_url' => true,
					'effect' => 'fade', // Options: 'fade', 'none'
					'pagination' => false,
					'echo' => true,
					'size' => 50,
				) );
			foreach ( $posts as $post ) {
				setup_postdata( $post );
				$s = "";
				if ($post->url)    $s.="<a href='".esc_url($post->url)."'>";
				                   $s .= $post->post_title;
				if ($post->byline) $s.= ", {$post->byline}";
				if ($post->url)    $s.="</a>";
				$instance['testimonials'][] = array (
					'quote_source_formatted' => $s,
					'content' => get_the_excerpt()
				);
			}
			break;
		case "category":
			$posts = get_posts( array(
					'posts_per_page' => $instance['limit'],
					'category' => $instance['category'] )
			);
			foreach ( $posts as $post ) {
				setup_postdata( $post );
				$s  = "<a href='".get_permalink( $post->ID )."'>";
				$title = get_the_title( $post->ID );
				$s .= "<cite title='$title'>$title</cite>";
				$s .= "</a>";             
				$instance['testimonials'][] = array (
					'quote_source_formatted' => $s,
					'content' => get_the_excerpt()
				);
			}
			break;
		}

		include dirname( __FILE__ ) . '/views/widget.php';

		echo $after_widget;

	} // end widget

	private function set_default( &$value, $default ) {
		if ( empty ( $value ) ) $value = $default;
	}

	private function is_testimonials_by_woothemes_installed() {
			return is_plugin_active("testimonials-by-woothemes/woothemes-testimonials.php");
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array   new_instance The previous instance of values before the update.
	 * @param array   old_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		foreach ( array( 'title', 'limit', 'datasource', 'category' ) as $field_name ) {
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

		$datasources = array();
		$datasources[] = array('name' => 'Category', 'value' => 'category');
		if ($this->is_testimonials_by_woothemes_installed()) { 
			$datasources[] = array( 'name' => 'Testimonials by WooThemes', 'value' => 'testimonials-by-woothemes' );
		}

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'limit' => 5,
				'datasource' => '',
				'category' => '',
				'datasources' => $datasources
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

		// TODO: Change 'widget-name' to the name of your plugin
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
