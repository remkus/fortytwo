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
class FT_Widget_Contact extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-contact';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'widget-' . $this->slug,
			__( '42&nbsp;&nbsp;- Contact Information', 'fortytwo' ),
			array(
				'classname'   => $this->slug,
				'description' => __( 'A Schema.org compliant Contact Widget', 'fortytwo' )
			)
		);

	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array   $instance Current settings
	 */
	public function form( $instance ) {

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
	 * Update a particular instance.
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array   $new_instance New settings for this instance as input by the user via form()
	 * @param array   $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {

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
	 * Echo the widget content.
	 *
	 * @param array   $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array   $instance The settings for the particular instance of the widget
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
				'title'     => '',
				'name'		=> '',
				'phone'		=> '',
				'fax'		=> '',
				'email'		=> '',
				'address'	=> '',
				'pc'		=> '',
				'city'		=> '',

			) );

		echo $args['before_widget'];
		include dirname( __FILE__ ) . '/views/widget.php';
		echo $args['after_widget'];
	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function admin_styles() {
		wp_enqueue_style( $this->slug . '-admin', $this->url( 'css/admin.css' ) );
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Contact");' ) );
