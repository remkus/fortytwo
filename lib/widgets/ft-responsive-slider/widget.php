<?php
/**
 * FortyTwo Theme: Responsive Slider Widget
 *
 * This file creates the Responsive Slider Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 *
 * Copyright & Thanks
 *
 * Thanks to Rafal Tomal, Nick Croft, Nathan Rice, Ron Rennick, Josh Byers and Brian Gardner for the original
 * responsive slider widget.
 *
 * Thanks to Tyler Smith for creating the awesome jquery FlexSlider plugin - http://flex.madebymufffin.com/.
 */

define( 'FT_RESPONSIVE_SLIDER_VERSION', '0.10.0' );

/**
 * Slideshow Widget Class
 */
class FT_Widget_Responsive_Slider extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-responsive-slider';

	public $all_widget_settings = array();

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
				'classname'   => 'ft-responsive-slider',
				'description' => __( 'Displays a slideshow inside a widget area', 'fortytwo' ),
			),
			array(
				'width'   => 200,
				'height'  => 250,
				'id_base' => 'ft-responsive-slider',
			)
		);

		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );

		//TODO: Which action should this be attached to?  It needs to be after $this->number is populated
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_slider_image_size' ) );

	}

	/**
	 * Add new image size
	 */
	public function register_slider_image_size() {
		//TODO: Should this be called once / widget?
		add_image_size( 'slider', (int) $this->get_value( 'slideshow_width' ), (int) $this->get_value( 'slideshow_height' ), true );
	}

	/**
	 * Creates read more link after excerpt
	 *
	 * @param mixed   moret  Not used
	 *
	 * @return An HTML fragment containing a "read more" link
	 */
	public function ft_responsive_slider_excerpt_more( $moret ) {
		global $post;
		static $read_more = null;

		if ( $read_more === null ) {
			$read_more = $this->get_value( 'slideshow_more_text' );
		}

		if ( ! $read_more ) {
			return '';
		}

		return '&hellip; <a href="'. esc_url( get_permalink( $post->ID ) ) . '">' . $read_more . '</a>';
	}

	/**
	 * Load the script files
	 */
	public function register_widget_scripts() {

		/* easySlider JavaScript code */
		wp_enqueue_script( 'flexslider', $this->url( 'js/jquery.flexslider-min.js' ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, true );

	}

	/**
	 * Load the style files
	 */
	public function register_widget_styles() {
		//no-op
	}

	/**
	 * Helper method to echo both the id= and name= attributes for a field input element
	 *
	 * @param string  field The field name
	 *
	 */
	public function echo_field_id( $field ) {
		echo ' id="' . $this->get_field_id( $field ) . '" name="' . $this->get_field_name( $field ) . '" ';
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array   args  The array of form elements
	 * @param array   instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		foreach ( array(
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
				'slideshow_effect',
				'slideshow_width',
				'slideshow_height',
				'slideshow_arrows',
				'slideshow_pager',
				'slideshow_no_link',
				'slideshow_title_show',
				'slideshow_excerpt_show',
				'slideshow_hide_mobile',
				'slideshow_excerpt_content',
				'slideshow_more_text',
				'slideshow_excerpt_content_limit',
				'slideshow_excerpt_width', ) as $field_name ) {
			$instance[ $field_name ] = apply_filters( 'widget_$field_name', $instance[ $field_name ] );
		}

		$term_args = array();

		if ( 'page' != $instance['post_type'] ) {
			if ( $instance['posts_term'] ) {
				$posts_term = explode( ',', $instance['posts_term'] );

				if ( 'category' == $posts_term['0'] ) {
					$posts_term['0'] = 'category_name';
				}

				if ( 'post_tag' == $posts_term['0'] ) {
					$posts_term['0'] = 'tag';
				}

				if ( isset( $posts_term['1'] ) ) {
					$term_args[ $posts_term['0'] ] = $posts_term['1'];
				}
			}

			if ( ! empty( $posts_term['0'] ) ) {
				if ( 'category' == $posts_term['0'] ) {
					$taxonomy = 'category';
				} elseif ( 'post_tag' == $posts_term['0'] ) {
					$taxonomy = 'post_tag';
				} else {
					$taxonomy = $posts_term['0'];
				}
			} else {
				$taxonomy = 'category';
			}

			if ( $instance['exclude_terms'] ) {
				$exclude_terms = explode( ',', str_replace( ' ', '', $instance['exclude_terms'] ) );

				$term_args[ $taxonomy . '__not_in' ] = $exclude_terms;

			}
		}

		if ( $instance['posts_offset'] ) {
			$myOffset = $instance['posts_offset'];
			$term_args['offset'] = $myOffset;
		}

		if ( $instance['post_id'] ) {
			$IDs = explode( ',', str_replace( ' ', '', $instance['post_id'] ) );
			if ( 'include' == $instance['include_exclude'] ) {
				$term_args['post__in'] = $IDs;
			} else {
				$term_args['post__not_in'] = $IDs;
			}
		}

		$query_args = array_merge( $term_args, array(
				'post_type'      => $instance['post_type'],
				'posts_per_page' => $instance['posts_num'],
				'orderby'        => $instance['orderby'],
			) );

		$query_args = apply_filters( 'ft_responsive_slider_query_args', $query_args );
		add_filter( 'excerpt_more', array( $this, 'ft_responsive_slider_excerpt_more' ) );

		$slider_posts = new WP_Query( $query_args );
		if ( $slider_posts->have_posts() ) {
			$show_excerpt  = $instance['slideshow_excerpt_show'];
			$show_title    = $instance['slideshow_title_show'];
			$show_type     = $instance['slideshow_excerpt_content'];
			$show_limit    = $instance['slideshow_excerpt_content_limit'];
			$more_text     = $instance['slideshow_more_text'];
			$no_image_link = $instance['slideshow_no_link'];

			$controlnav   = $instance['slideshow_pager'];
			$directionnav = $instance['slideshow_arrows'];

			$slide_image_width  = $instance['slideshow_width'];
			$slide_image_height = $instance['slideshow_height'];

			if ( 1 == $instance['slideshow_hide_mobile'] ) {
				$hide_mobile = array(
					'hide_excerpt'   => 'hide-on-mobile',
				);
			} else {
				$hide_mobile = array(
					'hide_excerpt'   => '',
				);
			}
		}

		// Display the widget frontend
		include dirname( __FILE__ ) . '/views/widget.php';

		echo $args['after_widget'];
		wp_reset_query(); // Needed?
		remove_filter( 'excerpt_more', array( &$this, 'ft_responsive_slider_excerpt_more' ) );

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
				'title'                           => '',
				'post_type'                       => 'post',
				'posts_term'                      => '',
				'exclude_terms'                   => '',
				'include_exclude'                 => 'include',
				'post_id'                         => '',
				'posts_num'                       => 3,
				'posts_offset'                    => 0,
				'orderby'                         => 'date',
				'slideshow_timer'                 => 4000,
				'slideshow_delay'                 => 800,
				'slideshow_effect'                => 'slide',
				'slideshow_width'                 => 1170,
				'slideshow_height'                => 420,
				'slideshow_arrows'                => 1,
				'slideshow_pager'                 => 0,
				'slideshow_no_link'               => 0,
				'slideshow_title_show'            => 1,
				'slideshow_excerpt_show'          => 1,
				'slideshow_hide_mobile'           => 0,
				'slideshow_excerpt_content'       => 'excerpts',
				'slideshow_more_text'             => __( 'Read More', 'fortytwo' ),
				'slideshow_excerpt_content_limit' => 300,
				'slideshow_excerpt_width'         => 7,
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
				'title',
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
				'slideshow_effect',
				'slideshow_width',
				'slideshow_height',
				'slideshow_arrows',
				'slideshow_pager',
				'slideshow_no_link',
				'slideshow_title_show',
				'slideshow_excerpt_show',
				'slideshow_hide_mobile',
				'slideshow_excerpt_content',
				'slideshow_more_text',
				'slideshow_excerpt_content_limit',
				'slideshow_excerpt_width',
			) as $field_name ) {
			$instance[ $field_name ] = ( ! empty( $new_instance[ $field_name ] ) ) ? strip_tags( $new_instance[ $field_name ] ) : '';
		}

		return $this->sanitization_values( $instance );

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		//TODO This custom style will need to be removed when jquery ui styles are included in WP - https://core.trac.wordpress.org/ticket/18909
		wp_enqueue_style( 'jquery-ui-styles-wp3.8', $this->url( 'css/wp-3-8-theme/jquery-ui-1.10.3.custom.min.css' ) );

		//Custom overrides
		wp_enqueue_style( 'ft-responsive-slider-admin-css', $this->url( 'css/admin.css' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'wp-lists' );

	}

	/**
	 * Sanitizes the values of the widget's instance variables
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	protected function sanitization_values( $instance ) {
		foreach ( $instance as $field => $value ) {
			if ( in_array( $field, array(
						'slideshow_arrows',
						'slideshow_excerpt_show',
						'slideshow_title_show',
						'slideshow_loop',
						'slideshow_hide_mobile',
						'slideshow_no_link',
						'slideshow_pager',
					) ) ) {
				if ( 1 == (int) $value ) {
					$instance[ $field ] = 1;
				} else {
					$instance[ $field ] = 0;
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
						'slideshow_excerpt_width',
					) ) ) {
				$instance[ $field ] = wp_filter_nohtml_kses( $value );
			}
		}

		return $instance;
	}

	/**
	 * Gets the value of a widget field setting
	 *
	 * @param string  field The name of the widget field you are wanting to get
	 * @param bool    force_reload Whether to force refetching value from DB. By default a cached value is returned
	 *
	 * @return The fetched field setting value
	 */
	protected function get_value( $field, $force_reload = false ) {
		//Cache sanitized widget values
		if ( 0 == count( $this->all_widget_settings ) || $force_reload ) {
			foreach ( $this->get_settings() as $key => $value ) {
				$this->all_widget_settings[ $key ] = $this->sanitization_values( $value );
			}
		}
		if ( isset( $this->all_widget_settings[ $this->number ] ) ) {
			return $this->all_widget_settings[ $this->number ][ $field ];
		}
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Responsive_Slider");' ) );
