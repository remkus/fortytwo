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
class FT_Featured_Content extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'ft-featured-content',
			__( '42&nbsp;&nbsp;- Featured Content', 'fortytwo' ),
			array(
				'classname'   => 'ft-featured-content',
				'description' => __( 'Featured Content widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

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

	}

	/**
	 * Set a default value for an empty variable
	 *
	 * @param mixed   value The variable whoes default should be set.  NB!  This variable's value is set to default if empty()
	 * @param mixed   default The default value
	 */
	private function set_default( &$value, $default ) {
		if ( empty ( $value ) ) $value = $default;
	}

	/**
	 * Helper method to echo both the id= and name= attributes for a field input element
	 *
	 * @param string  field The field name
	 *
	 */
	public function echo_field_id( $field ) {
		echo ' id="'.$this->get_field_id( $field ). '" name="' .$this->get_field_name( $field ) . '" ';
	}

	/**
	 * Returns an absolute URL to a file releative to the widget's folder
	 *
	 * @param string  file The file path (relative to the widgets folder)
	 *
	 * @return string
	 */
	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL.'/ft-featured-content'.$file;
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
			'button_link'
			) as $field_name ) {
			$instance[$field_name] = ( !empty( $new_instance[$field_name] ) ) ? strip_tags( $new_instance[$field_name] ) : '';
		}

		return $instance;

	} // end update()

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

		wp_enqueue_style( 'ft-featured-content-admin-styles', $this->url( '/css/admin.css' ) );
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
		wp_enqueue_script( 'add_event_saved_widget', $this->url( '/js/add_event_saved_widget.js' ),  array( 'backbone' ) );
		wp_enqueue_script( 'fontawesome_icon_selector_app', $this->url( '/js/fontawesome_icon_selector_app.js' ), array( 'backbone' ) );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( 'ft-featured-content-widget-styles', $this->url( '/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( 'ft-featured-content-script', $this->url( '/js/widget.js' ) );

	} // end register_widget_scripts

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Featured_Content");' ) );
