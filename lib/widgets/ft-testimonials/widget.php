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
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'widget-ft-testimonials',
			__( '42&nbsp;&nbsp;- Testimonials', 'fortytwo' ),
			array(
				'classname'   => 'ft-testimonials',
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

		$datasources = array();
		$datasources[] = array(
			'name' => 'Category',
			'value' => 'category',
		)
		;
		if ( $this->is_testimonials_by_woothemes_installed() ) {
			$datasources[] = array(
				'name' => 'Testimonials by WooThemes',
				'value' => 'testimonials-by-woothemes',
			);
		}

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'       => '',
				'limit'       => 5,
				'datasource'  => '',
				'category'    => '',
				'datasources' => $datasources,
			)
		);

		// Display the admin form
		include dirname( __FILE__ ) . '/views/form.php';

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
			$instance[ $field_name ] = ( ! empty( $new_instance[ $field_name ] ) ) ? strip_tags( $new_instance[ $field_name ] ) : '';
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

		echo $args['before_widget'];

		foreach ( array( 'title', 'limit', 'datasource', 'category' ) as $field_name ) {
			$instance[ $field_name ] = apply_filters( "widget_{$field_name}", $instance[ $field_name ] );
		}

		$this->set_default( $instance['title'], __( 'Client Testimonials', 'fortytwo' ) );
		$this->set_default( $instance['limit'], 5 );
		$this->set_default( $instance['datasource'], 'category' );
		$this->set_default( $instance['category'], 1 );
		$this->set_default( $instance['testimonials'], array() );

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

		include dirname( __FILE__ ) . '/views/widget.php';

		echo $args['after_widget'];

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
		wp_enqueue_style( 'ft-testimonials-admin-styles',  $this->url( 'css/admin.css' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'ft-testimonials-admin-script', $this->url( 'js/admin.js' ) );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function widget_styles() {
		wp_enqueue_style( 'ft-testimonials-widget-styles', $this->url( 'css/widget.css' ) );
	}

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function widget_scripts() {
		wp_enqueue_script( 'ft-testimonials-script', $this->url( 'js/widget.js' ) );
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Testimonials");' ) );
