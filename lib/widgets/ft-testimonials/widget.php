<?php
/**
 * FortyTwo Theme: Testimonials Widget
 *
 * This file creates the Testimonials Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 * Required for use of is_plugin_active() -
 *
 * @link http://codex.wordpress.org/Function_Reference/is_plugin_active#Usage
 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';

class FT_Widget_Testimonials extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-testimonials';

	/**
	 * Instantiate the widget class.
	 */
	public function __construct() {
		$this->defaults = array(
			'title'      => '',
			'limit'      => 5,
			'datasource' => '',
			'category'   => '',
		);

		parent::__construct(
			$this->slug,
			__( '42 - Testimonials', 'fortytwo' ),
			array(
				'classname'   => 'widget-' . $this->slug,
				'description' => __( 'Testimonials widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$defaults = $this->defaults;
		$defaults['datasources'] = $this->get_datasources();

		$instance = wp_parse_args( $instance, $defaults );

		include dirname( __FILE__ ) . '/views/form.php';
	}

	/**
	 * Update a particular instance.
	 * 
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form().
	 * @param array $old_instance Old settings for this instance.
	 * 
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		foreach ( $this->get_fields() as $field ) {
			$instance[ $field ] = ( ! empty( $new_instance[ $field ] ) ) ? strip_tags( $new_instance[ $field ] ) : '';
		}

		return $instance;

	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array   args  The array of form elements
	 * @param array   instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		foreach ( $this->get_fields() as $field ) {
			$instance[ $field ] = apply_filters( "widget_{$field}", $instance[ $field ], $instance, $this->id_base );
		}

		switch ( $instance['datasource'] ) {
			case 'testimonials-by-woothemes':
				if ( ! $this->is_testimonials_by_woothemes_installed() ){
					break;
				}

				$posts = woothemes_get_testimonials( array(
					'limit'          => $instance['limit'],
					'orderby'        => 'menu_order',
					'order'          => 'DESC',
					'display_author' => true,
					'display_avatar' => true,
					'display_url'    => true,
					'effect'         => 'fade', // Options: 'fade', 'none'
					'pagination'     => false,
					'echo'           => true,
					'size'           => 50,
					) );

				foreach ( $posts as $post ) {
					setup_postdata( $post );
					$s = '';

					if ( $post->url ) {
						$s .= "<a href='" . esc_url( $post->url ) . "'>";
					}

					$s .= $post->post_title;

					if ( $post->byline ) {
						$s .= ', ' . $post->byline;
					}

					if ( $post->url ) {
						$s .= '</a>';
					}

					$instance['testimonials'][] = array(
						'quote_source_formatted' => $s,
						'content'                => get_the_excerpt(),
					);
				}
				break;
			case 'category':
				$posts = get_posts( array(
						'posts_per_page' => $instance['limit'],
						'category'       => $instance['category'], )
				);

				foreach ( $posts as $post ) {
					setup_postdata( $post );
					$title = get_the_title( $post->ID );
					$s  = '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">'
						. '<cite title="' . esc_attr( $title ) . '">' . $title . '</cite>'
						. '</a>';

					$instance['testimonials'][] = array(
						'quote_source_formatted' => $s,
						'content'                => get_the_excerpt(),
					);
				}
				break;
		}

		echo $args['before_widget'];
		include dirname( __FILE__ ) . '/views/widget.php';
		echo $args['after_widget'];
	}

	/**
	 * Get datasources.
	 *
	 * @return array Datasources for testimonials.
	 */
	protected function get_datasources() {
		$datasources = array();
		$datasources[] = array(
			'name'  => __( 'Category', 'fortytwo' ),
			'value' => 'category',
		);

		if ( $this->is_testimonials_by_woothemes_installed() ) {
			$datasources[] = array(
				'name'  => __( 'Testimonials by WooThemes', 'fortytwo' ),
				'value' => 'testimonials-by-woothemes',
			);
		}

		return apply_filters( "{$this->slug}_datasources", $datasources );
	}

	/**
	 * Check if Testimonials by WooThemes plugin is active.
	 *
	 * @return bool true|false depending on whether the testimonials_by_woothemes plugin is installed
	 */
	private function is_testimonials_by_woothemes_installed() {
		return is_plugin_active( 'testimonials-by-woothemes/woothemes-testimonials.php' );
	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function admin_styles() {
		// TODO: Change 'widget-name' to the name of your plugin
		wp_enqueue_style( $this->slug . '-admin',  $this->url( 'css/admin.css' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function admin_scripts() {
		wp_enqueue_script( $this->slug . '-admin', $this->url( 'js/admin.js' ) );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function widget_styles() {
		wp_enqueue_style( $this->slug, $this->url( 'css/widget.css' ) );
	}

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function widget_scripts() {
		wp_enqueue_script( $this->slug, $this->url( 'js/widget.js' ) );
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Testimonials");' ) );
