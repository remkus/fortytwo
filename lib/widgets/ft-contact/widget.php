<?php
/**
 * FortyTwo Theme: Adds a Schema.org compliant contact widget.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 * ForSite Themes Contact widget class.
 *
 * @package Genesis
 * @subpackage Widgets
 * @since 1.0.0
 */
class FT_Contact_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'widget-ft-contact',
			__( 'FortyTwo - Contact', 'fortytwo' ),
			array(
				'classname'   => 'ft-contact',
				'description' => __( 'A Schema.org compliant Contact Widget', 'fortytwo' )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );

	} // end constructor

	/**
	 * Returns an absolute URL to a file releative to the widget's folder
	 *
	 * @param string   file The file path (relative to the widgets folder)
	 *
	 * @return string
	 */
	private function url( $file ) {
		return FORTYTWO_WIDGETS_URL . '/ft-contact' . $file;
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array   $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array   $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$instance = wp_parse_args( (array) $instance, array(
				'title'     => '',
				'name'		=> '',
				'phone'		=> '',
				'fax'		=> '',
				'email'		=> '',
				'address'	=> '',
				'pc'		=> '',
				'city'		=> ''

			) );

		echo $before_widget;
		include dirname( __FILE__ ) . '/views/widget.php';
		echo $after_widget;
	}

	/**
	 * Update a particular instance.
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array   $new_instance New settings for this instance as input by the user via form()
	 * @param array   $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['name']		= strip_tags( $new_instance['name'] );
		$new_instance['phone']		= strip_tags( $new_instance['phone'] );
		$new_instance['email']		= strip_tags( $new_instance['email'] );
		$new_instance['address']	= strip_tags( $new_instance['address'] );
		$new_instance['pc']			= strip_tags( $new_instance['pc'] );
		$new_instance['cityl']		= strip_tags( $new_instance['city'] );
		$new_instance['fax']		= strip_tags( $new_instance['fax'] );

		return $new_instance;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array   $instance Current settings
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
				'name'		=> '',
				'phone'		=> '',
				'email'		=> '',
				'fax'		=> '',
				'address'	=> '',
				'pc'		=> '',
				'city'		=> '',
			) );

		include dirname( __FILE__ ) . '/views/form.php';

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( 'ft-contact-admin-styles', $this->url( '/css/admin.css' ) );

	} // end register_admin_styles


}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Contact_Widget");' ) );
