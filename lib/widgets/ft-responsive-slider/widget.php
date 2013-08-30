<?php
/*
	Description: A responsive featured slider for the Genesis Framework.
	Author: Forsite Themes
	Based on: Genesis Responsive Slider by StudioPress
	Author URI: http://forsitethemes.com
	Author Email: mail@forsitethemes.com
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

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

/**
 * Props to Rafal Tomal, Nick Croft, Nathan Rice, Ron Rennick, Josh Byers and Brian Gardner for collaboratively writing this plugin.
 */

/**
 * Thanks to Tyler Smith for creating the awesome jquery FlexSlider plugin - http://flex.madebymufffin.com/.
 */

define( 'FT_RESPONSIVE_SLIDER_SETTINGS_FIELD', 'ft_responsive_slider_settings' );
define( 'FT_RESPONSIVE_SLIDER_VERSION', '0.9.2' );

// Include Admin file 
if ( is_admin() ) require_once dirname( __FILE__ ) . '/admin.php';

function ft_responsive_slider_url( $file ) {
	return FORTYTWO_WIDGETS_URL.'/ft-responsive-slider'.$file;
}

	/* Creates read more link after excerpt */
	function ft_responsive_slider_excerpt_more( $more ) {
		global $post;
		static $read_more = null;

		if ( $read_more === null )
			$read_more = ft_get_responsive_slider_option( 'slideshow_more_text' );

		if ( !$read_more )
			return '';

		return '&hellip; <a href="'. get_permalink( $post->ID ) . '">' . __( $read_more, 'fortytwo' ) . '</a>';
	}

	/**
	 * Used to exclude taxonomies and related terms from list of available terms/taxonomies in widget form().
	 *
	 * @since 0.9
	 * @author Nick Croft
	 *
	 * @param string  $taxonomy 'taxonomy' being tested
	 * @return string
	 */
	function ft_responsive_slider_exclude_taxonomies( $taxonomy ) {

		$filters = array( '', 'nav_menu' );
		$filters = apply_filters( 'ft_responsive_slider_exclude_taxonomies', $filters );

		return ! in_array( $taxonomy->name, $filters );

	}

	/**
	 * Used to exclude post types from list of available post_types in widget form().
	 *
	 * @since 0.9
	 * @author Nick Croft
	 *
	 * @param string  $type 'post_type' being tested
	 * @return string
	 */
	function ft_responsive_slider_exclude_post_types( $type ) {

		$filters = array( '', 'attachment' );
		$filters = apply_filters( 'ft_responsive_slider_exclude_post_types', $filters );

		return ! in_array( $type, $filters );

	}

	/**
	 * Returns Slider Option
	 *
	 * @param string  $key key value for option
	 * @return string
	 */
	function ft_get_responsive_slider_option( $key ) {
		return genesis_get_option( $key, FT_RESPONSIVE_SLIDER_SETTINGS_FIELD );
	}

	/**
	 * Echos Slider Option
	 *
	 * @param string  $key key value for option
	 */
	function ft_responsive_slider_option( $key ) {

		if ( ! ft_get_responsive_slider_option( $key ) )
			return false;

		echo ft_get_responsive_slider_option( $key );
	}

//#### below ######### Already refactored to FT widget structure #########

/**
 * Slideshow Widget Class
 */
class FT_Responsive_Slider extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
		global $_ft_responsive_slider_settings_pagehook;

		parent::__construct(
			'ft-responsive-slider',
			__( 'FortyTwo - Responsive Slider', 'fortytwo' ),
			array(
				'classname' => 'ft-responsive-slider',
				'description' => __( 'Displays a slideshow inside a widget area', 'fortytwo' )
			),
			array( 
				'width' => 200, 
				'height' => 250, 
				'id_base' => 'ft-responsive-slider' 
			)
		);
	
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'ft_responsive_slider_sanitization' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
		add_action( 'wp_footer', array( $this, 'ft_responsive_slider_flexslider_params' ) );

		/* Add new image size */
		add_image_size( 'slider', ( int ) ft_get_responsive_slider_option( 'slideshow_width' ), ( int ) ft_get_responsive_slider_option( 'slideshow_height' ), TRUE );
	}

	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL.'/ft-responsive-slider'.$file;
	}
	/**
	 * Add settings to Genesis sanitization
	 *
	 */
	function ft_responsive_slider_sanitization() {
		genesis_add_option_filter( 'one_zero', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD,
			array(
				'slideshow_arrows',
				'slideshow_excerpt_show',
				'slideshow_title_show',
				'slideshow_loop',
				'slideshow_hide_mobile',
				'slideshow_no_link',
				'slideshow_pager'
			) );
		genesis_add_option_filter( 'no_html', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD,
			array(
				'post_type',
				'posts_term',
				'exclude_terms',
				'include_exclude',
				'post_id',
				'posts_num',
				'posts_offset',
				'orderby',
				'slideshow_timer',
				'slideshow_delay',
				'slideshow_height',
				'slideshow_width',
				'slideshow_effect',
				'slideshow_excerpt_content',
				'slideshow_excerpt_content_limit',
				'slideshow_more_text',
				'slideshow_excerpt_width',
			) );
	}

	/**
	 * Load the script files
	 */
	function register_widget_scripts() {

		/* easySlider JavaScript code */
		wp_enqueue_script( 'flexslider', $this->url( '/js/jquery.flexslider-min.js' ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, TRUE );

	}

	/**
	 * Load the style files
	 */
	function register_widget_styles() {
			//no-op
	}

	/**
	 * Outputs slider script on wp_footer hook.
	 */
	function ft_responsive_slider_flexslider_params() {

		$timer = ( int ) ft_get_responsive_slider_option( 'slideshow_timer' );
		$duration = ( int ) ft_get_responsive_slider_option( 'slideshow_delay' );
		$effect = ft_get_responsive_slider_option( 'slideshow_effect' );
		$controlnav = ft_get_responsive_slider_option( 'slideshow_pager' );
		$directionnav = ft_get_responsive_slider_option( 'slideshow_arrows' );

		$output = 'jQuery(document).ready(function($) {
					$(".slider-inner").flexslider({
						controlsContainer: ".slider-inner",
						animation: "' . esc_js( $effect ) . '",
						directionNav: ' . $directionnav . ',
						controlNav: ' . $controlnav . ',
						animationSpeed: ' . $duration . ',
						slideshowSpeed: ' . $timer . ',
						prevText: "",
						nextText: "",
						useCSS: false,
						start: function(slider){
							var arr = [ "slider-inner", "slider-nav" ];
							$.each(arr, function() {
								$("." + this).removeClass("invisible");
							});

						}
				    });
				  });';

		$output = str_replace( array( "\n", "\t", "\r" ), '', $output );

		echo '<script type=\'text/javascript\'>' . $output . '</script>';
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
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $title )
			echo $before_title . $title . $after_title;

		// Display the widget frontend
		include dirname( __FILE__ ) . '/views/widget.php';

		echo $after_widget;
		wp_reset_query();
		remove_filter( 'excerpt_more', 'ft_responsive_slider_excerpt_more' );

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		
		$title = $instance['title'];

		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$post_types = array_filter( $post_types, 'ft_responsive_slider_exclude_post_types' );

		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

		$taxonomies = array_filter( $taxonomies, 'ft_responsive_slider_exclude_taxonomies' );
		$test = get_taxonomies( array( 'public' => true ), 'objects' );


		// Display the admin form
		include dirname( __FILE__ ) . '/views/form.php';
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array   old_instance The previous instance of values before the update.
	 * @param array   new_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		foreach ( array( 'title' ) as $field_name ) {
			$instance[$field_name] = ( !empty( $new_instance[$field_name] ) ) ? strip_tags( $new_instance[$field_name] ) : '';
		}

		return $instance;

	} // end update()

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	function register_admin_styles() {

		wp_enqueue_style ( 'ft-responsive-slider-admin-css', $this->url( '/css/admin.css' ) );
		//TODO These styles will need to be removed when jquery ui styles are included in WP 3.3 - https://core.trac.wordpress.org/ticket/18909
		wp_enqueue_style ( 'jquery-ui-fresh', $this->url( '/css/jquery-ui-fresh.css' ) ); 
		wp_enqueue_style ( 'jquery-ui-styles', $this->url( '/css/jquery-ui-styles.css' ) );
		
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	function register_admin_scripts() {

		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'ft_responsive_slider_admin_scripts', ft_responsive_slider_url( '/js/admin.js' ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, TRUE );

	} // end register_admin_scripts

}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Responsive_Slider");' ) );
