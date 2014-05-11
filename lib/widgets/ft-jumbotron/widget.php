<?php
/**
 * FortyTwo Theme: Jumbotron Widget
 *
 * This file creates the Jumbotron Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

class FT_Widget_Jumbotron extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-jumbotron';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'widget-' . $this->slug,
			__( '42&nbsp;&nbsp;- Jumbotron', 'fortytwo' ),
			array(
				'classname'   => $this->slug,
				'description' => __( 'Jumbotron widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array   instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'            => '',
				'content'          => '',
				'button_alignment' => 'right',
				'button_text'      => '',
				'button_link'      => '',
			)
		);

		// Display the admin form
		include dirname( __FILE__ )  . '/views/form.php';

	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array   new_instance The previous instance of values before the update.
	 * @param array   old_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		foreach ( array(
			'title',
			'content',
			'button_text',
			'button_link',
			'button_alignment',
			) as $field_name ) {
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

		foreach ( array( 'title', 'content', 'button_text', 'button_link', 'button_alignment' ) as $field_name ) {
			$instance[ $field_name ] = apply_filters( "widget_{$field_name}", $instance[ $field_name ] );
		}
		$this->set_default( $instance['title'], __( 'Announcing the most important product feature', 'fortytwo' ) );
		$this->set_default( $instance['content'], __( 'And purely one near this hey therefore darn firefly had ducked overpaid wow!', 'fortytwo' ) );
		$this->set_default( $instance['button_text'], __( 'Purchase Today !', 'fortytwo' ) );
		$this->set_default( $instance['button_link'], '#' );
		$this->set_default( $instance['button_alignment'], 'right' );

		include dirname( __FILE__ ) . '/views/widget.php';

		echo $args['after_widget'];

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( $this->slug . '-admin', $this->url( 'css/admin.css' ) );
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

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Jumbotron");' ) );
