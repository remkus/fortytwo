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
 * Thanks to Rafal Tomal, Nick Croft, Nathan Rice, Ron Rennick, Josh Byers and Brian Gardner for the original
 * responsive slider widget.
 */

/**
 * Thanks to Tyler Smith for creating the awesome jquery FlexSlider plugin - http://flex.madebymufffin.com/.
 */

define( 'FT_RESPONSIVE_SLIDER_VERSION', '0.10.0' );

/**
 * Slideshow Widget Class
 */
class FT_Responsive_Slider extends WP_Widget {

	public $all_widget_settings = array();

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
			__( '42&nbsp;&nbsp;- Responsive Slider', 'fortytwo' ),
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

		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );

		//TODO: Which action should this be attached to?  It needs to be after $this->number is populated
		add_action ( 'wp_enqueue_scripts', array( &$this, 'register_slider_image_size' ) );

	}

	/**
	 * Add new image size
	 */
	public function register_slider_image_size() {
		//TODO: Should this be called once / widget?
		add_image_size( 'slider', ( int ) $this->get_value( 'slideshow_width' ), ( int ) $this->get_value( 'slideshow_height' ), TRUE );
	}
	
	/**
	 * Returns an absolute URL to a file releative to the widget's folder
	 * 
	 * @param string   file The file path (relative to the widgets folder)
	 *
	 * @return string
	 */
	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL.'/ft-responsive-slider'.$file;
	}

	/**
	 * Sanitizes the values of the widget's instance variables
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	private function sanitization_values( $instance ) {
		foreach ( $instance as $field => $value ) {
			if ( in_array( $field, array(
						'slideshow_arrows',
						'slideshow_excerpt_show',
						'slideshow_title_show',
						'slideshow_loop',
						'slideshow_hide_mobile',
						'slideshow_no_link',
						'slideshow_pager'
					) ) ) {
				if ( (int) $value == 1 ) {
					$instance[$field] = 1;
				} else {
					$instance[$field] = 0;
				}
			}
			if ( in_array( $field, array(
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
						'slideshow_excerpt_width'
					) ) ) {
				$instance[$field] = wp_filter_nohtml_kses( $value );
			}
		}
		return $instance;
	}

	/**
	 * Gets the value of a widget field setting
	 *
	 * @param string   field The name of the widget field you are wanting to get
	 * @param bool     force_reload Whether to force refetching value from DB. By default a cached value is returned
	 *
	 * @return The fetched field setting value
	 */
	private function get_value( $field, $force_reload = false ) {
		//Cache sanitized widget values
		if ( count( $this->all_widget_settings )==0 || $force_reload ) {
			foreach ( $this->get_settings() as $key => $value ) {
				$this->all_widget_settings[$key] = $this->sanitization_values( $value );
			}
		}
		if ( isset( $this->all_widget_settings[$this->number] ) )
			return $this->all_widget_settings[$this->number][$field];
	}

	/**
	 * Creates read more link after excerpt 
	 * 
	 * @param mixed   moret  Not used
	 *
	 * @return An HTML fragment containing a "read more" link
	 */
	function ft_responsive_slider_excerpt_more( $moret ) {
		global $post;
		static $read_more = null;

		if ( $read_more === null )
			$read_more = $this->get_value( 'slideshow_more_text' );

		if ( !$read_more )
			return '';

		return '&hellip; <a href="'. get_permalink( $post->ID ) . '">' . __( $read_more, 'fortytwo' ) . '</a>';
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
	 * Helper method to echo both the id= and name= attributes for a field input element
	 * 
	 * @param string   field The field name
	 *
	 */
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
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $title )
			echo $before_title . $title . $after_title;

		foreach ( array(
				'post_type'
				,'posts_term'
				,'exclude_terms'
				,'include_exclude'
				,'post_id'
				,'posts_num'
				,'posts_offset'
				,'orderby'
				,'slideshow_timer'
				,'slideshow_delay'
				,'slideshow_effect'
				,'slideshow_width'
				,'slideshow_height'
				,'slideshow_arrows'
				,'slideshow_pager'
				,'slideshow_no_link'
				,'slideshow_title_show'
				,'slideshow_excerpt_show'
				,'slideshow_hide_mobile'
				,'slideshow_excerpt_content'
				,'slideshow_more_text'
				,'slideshow_excerpt_content_limit'
				,'slideshow_excerpt_width' ) as $field_name ) {
			$instance[$field_name] = apply_filters( 'widget_$field_name', $instance[ $field_name ] );
		}

		$term_args = array( );

		if ( 'page' != $instance['post_type'] ) {

			if ( $instance['posts_term'] ) {

				$posts_term = explode( ',', $instance['posts_term'] );

				if ( 'category' == $posts_term['0'] )
					$posts_term['0'] = 'category_name';

				if ( 'post_tag' == $posts_term['0'] )
					$posts_term['0'] = 'tag';

				if ( isset( $posts_term['1'] ) )
					$term_args[$posts_term['0']] = $posts_term['1'];

			}

			if ( !empty( $posts_term['0'] ) ) {

				if ( 'category' == $posts_term['0'] )
					$taxonomy = 'category';

				elseif ( 'post_tag' == $posts_term['0'] )
					$taxonomy = 'post_tag';

				else
					$taxonomy = $posts_term['0'];

			} else {
				$taxonomy = 'category';

			}

			if ( $instance['exclude_terms'] ) {

				$exclude_terms = explode( ',', str_replace( ' ', '', $instance['exclude_terms'] ) );
				$term_args[$taxonomy . '__not_in'] = $exclude_terms;

			}
		}

		if ( $instance['posts_offset'] ) {
			$myOffset = $instance['posts_offset'];
			$term_args['offset'] = $myOffset;
		}

		if ( $instance['post_id'] ) {
			$IDs = explode( ',', str_replace( ' ', '', $instance['post_id'] ) );
			if ( 'include' == $instance['include_exclude'] )
				$term_args['post__in'] = $IDs;
			else
				$term_args['post__not_in'] = $IDs;
		}

		$query_args = array_merge( $term_args, array(
				'post_type' => $instance['post_type'],
				'posts_per_page' => $instance['posts_num'],
				'orderby' => $instance['orderby'],
			) );

		$query_args = apply_filters( 'ft_responsive_slider_query_args', $query_args );
		add_filter( 'excerpt_more', array( &$this, 'ft_responsive_slider_excerpt_more' ) );

		$slider_posts = new WP_Query( $query_args );
		if ( $slider_posts->have_posts() ) {
			$show_excerpt = $instance['slideshow_excerpt_show'];
			$show_title = $instance['slideshow_title_show'];
			$show_type = $instance['slideshow_excerpt_content'];
			$show_limit = $instance['slideshow_excerpt_content_limit'];
			$more_text = $instance['slideshow_more_text'];
			$no_image_link = $instance['slideshow_no_link'];

			$controlnav = $instance['slideshow_pager'];
			$directionnav = $instance['slideshow_arrows'];

			$slide_excerpt_col = ( int ) $instance['slideshow_excerpt_width'];
			$slide_image_col = 12 - $slide_excerpt_col;

			if ( $instance['slideshow_hide_mobile'] == 1 ) {
				$hide_mobile = array(
					'hide_excerpt'   => ' hidden-xs',
					'add_image_cols' => ' col-xs-12'
				);
			} else {
				$hide_mobile = array(
					'hide_excerpt'   => '',
					'add_image_cols' => ''
				);
			}

		}

		// Display the widget frontend
		include dirname( __FILE__ ) . '/views/widget.php';

		echo $after_widget;
		wp_reset_query();
		remove_filter( 'excerpt_more', array( &$this, 'ft_responsive_slider_excerpt_more' ) );

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
				'title' => ''
				, 'post_type' => 'post'
				, 'posts_term' => ''
				, 'exclude_terms' => ''
				, 'include_exclude' => 'include'
				, 'post_id' => ''
				, 'posts_num' => 3
				, 'posts_offset' => 0
				, 'orderby' => 'date'
				, 'slideshow_timer' => 4000
				, 'slideshow_delay' => 800
				, 'slideshow_effect' => 'slide'
				, 'slideshow_width' => 1170
				, 'slideshow_height' => 420
				, 'slideshow_arrows' => 1
				, 'slideshow_pager' => 0
				, 'slideshow_no_link' => 0
				, 'slideshow_title_show' => 1
				, 'slideshow_excerpt_show' => 1
				, 'slideshow_hide_mobile' => 0
				, 'slideshow_excerpt_content' => 'excerpts'
				, 'slideshow_more_text' => __( 'Read More', 'fortytwo' )
				, 'slideshow_excerpt_content_limit' => 300
				, 'slideshow_excerpt_width' => 7
			) );

		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$instance['post_types'] = array_filter( $post_types, array( &$this, 'ft_responsive_slider_exclude_post_types' ) );

		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
		$instance['taxonomies'] = array_filter( $taxonomies, array( &$this, 'ft_responsive_slider_exclude_taxonomies' ) );

		$instance['test'] = get_taxonomies( array( 'public' => true ), 'objects' );

		// Display the admin form
		include dirname( __FILE__ ) . '/views/form.php';
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
	 * Processes the widget's options to be saved.
	 *
	 * @param array   old_instance The previous instance of values before the update.
	 * @param array   new_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		foreach ( array(
				'title'
				,'post_type'
				,'posts_term'
				,'exclude_terms'
				,'include_exclude'
				,'post_id'
				,'posts_num'
				,'posts_offset'
				,'orderby'
				,'slideshow_timer'
				,'slideshow_delay'
				,'slideshow_effect'
				,'slideshow_width'
				,'slideshow_height'
				,'slideshow_arrows'
				,'slideshow_pager'
				,'slideshow_no_link'
				,'slideshow_title_show'
				,'slideshow_excerpt_show'
				,'slideshow_hide_mobile'
				,'slideshow_excerpt_content'
				,'slideshow_more_text'
				,'slideshow_excerpt_content_limit'
				,'slideshow_excerpt_width'
			) as $field_name ) {
			$instance[$field_name] = ( !empty( $new_instance[$field_name] ) ) ? strip_tags( $new_instance[$field_name] ) : '';
		}

		return $this->sanitization_values( $instance );

	} // end update()

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	function register_admin_styles() {
		//TODO This custom style will need to be removed when jquery ui styles are included in WP - https://core.trac.wordpress.org/ticket/18909
		wp_enqueue_style ( 'jquery-ui-styles-wp3.8', $this->url( '/css/wp-3-8-theme/jquery-ui-1.10.3.custom.min.css' ) );

		//Custom overrides
		wp_enqueue_style ( 'ft-responsive-slider-admin-css', $this->url( '/css/admin.css' ) );
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	function register_admin_scripts() {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'ft_responsive_slider_admin_scripts', $this->url( '/js/admin.js' ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, TRUE );

	} // end register_admin_scripts

}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Responsive_Slider");' ) );
