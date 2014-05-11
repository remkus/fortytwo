<?php
/**
 * FortyTwo Theme: Featured Content Widget
 *
 * This file creates the Featured Content Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 *  @todo  This code needs better documentation
 */
class FT_Widget_Featured_Content extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-featured-content';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'widget-' . $this->slug,
			__( '42&nbsp;&nbsp;- Featured Content', 'fortytwo' ),
			array(
				'classname'   => $this->slug,
				'description' => __( 'Featured Content widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);

	}

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
				'title'       => '',
				'icon'        => '',
				'content'     => '',
				'button_text' => '',
				'button_link' => '',
			)
		);

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
		foreach ( array(
			'title',
			'icon',
			'content',
			'button_text',
			'button_link',
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

		foreach ( array( 'title', 'icon', 'content', 'button_text', 'button_link' ) as $field_name ) {
			$instance[ $field_name ] = apply_filters( "widget_{$field_name}", $instance[ $field_name ] );
		}
		$this->set_default( $instance['title'], __( 'The title', 'fortytwo' ) );
		$this->set_default( $instance['icon '], 'icon-star' );
		$this->set_default( $instance['content'], __( 'And purely one near this hey therefore darn firefly had ducked overpaid wow irrespective some tearful and mandrill
    yikes considering far above. Physically less snickered much and and while', 'fortytwo' ) );
		$this->set_default( $instance['button_text'], __( 'Click me!', 'fortytwo' ) );
		$this->set_default( $instance['button_link'], '#' );

		include dirname( __FILE__ )  . '/views/widget.php';

		echo $args['after_widget'];

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( $this->slug . 'admin', $this->url( 'css/admin.css' ) );
		wp_enqueue_style( 'fontawesome-icon-selector-app', $this->url( 'css/fontawesome_icon_selector_app.css' ), array( 'font-awesome-more' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function admin_scripts() {
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'jquery-effects-slide' );
		wp_enqueue_script( 'backbone' );
		wp_enqueue_script( 'add-event-saved-widget', $this->url( 'js/add_event_saved_widget.js' ),  array( 'backbone' ) );
		wp_enqueue_script( 'fontawesome-icon-selector-app', $this->url( 'js/fontawesome_icon_selector_app.js' ), array( 'backbone' ) );
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

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Featured_Content");' ) );
