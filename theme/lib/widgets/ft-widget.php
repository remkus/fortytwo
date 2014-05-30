<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 * Base widget class.
 *
 * @package FortyTwo
 * @author  Forsite Themes
 */
abstract class FT_Widget extends WP_Widget {
	/**
	 * Holds widget settings defaults.
	 *
	 * @since @@release
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Initialise widget class.
	 *
	 * @since @@release
	 *
	 * @param string $id_base        Optional Base ID for the widget, lower case,
	 * if left empty a portion of the widget's class name will be used. Has to be unique.
	 * @param string $name           Name for the widget displayed on the configuration page.
	 * @param array  $widget_options Optional Passed to wp_register_sidebar_widget()
	 *	 - description: shown on the configuration page
	 *	 - classname
	 * @param array $control_options Optional Passed to wp_register_widget_control()
	 *	 - width: required if more than 250px
	 *	 - height: currently not used but may be needed in the future
	 */
	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {
		$this->hooks();

		$this->defaults = apply_filters( "{$this->slug}_widget_defaults", $this->defaults );

		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	/**
	 * Echo the settings update form.
	 *
	 * @since @@release
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		include trailingslashit( dirname( __FILE__ ) ) . $this->slug . '/views/form.php';
	}

	/**
	 * Echo the widget content.
	 *
	 * @since @@release
	 *
	 * @param array   $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array   $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		foreach ( $this->get_fields() as $field ) {
			$instance[ $field ] = apply_filters( "widget_{$field}", $instance[ $field ], $instance, $this->id_base );
		}

		if ( ! $this->has_value( $instance ) ) {
			return;
		}

		echo $args['before_widget'];
		include trailingslashit( dirname( __FILE__ ) ) . $this->slug . '/views/widget.php';
		echo $args['after_widget'];
	}

	/**
	 * Apply automatic hooks for known method names.
	 *
	 * @since @@release
	 */
	protected function hooks() {
		global $pagenow;
		$hooks = array(
			'wp_enqueue_scripts' => array( 'widget_styles', 'widget_scripts', ),
		);

		if ( is_admin() && 'widgets.php' === $pagenow ) {
			$hooks['admin_enqueue_scripts'] = array( 'admin_styles', 'admin_scripts', );
		}

		foreach ( $hooks as $hook => $methods ) {
			foreach ( $methods as $method ) {
				if ( method_exists( $this, $method ) ) {
					add_action( $hook, array( $this, $method ) );
				}
			}
		}
	}

	/**
	 * Return an absolute URL to a file relative to the widget's folder.
	 *
	 * @since @@release
	 *
	 * @param string $file The file path (relative to the widget's folder).
	 *
	 * @return string
	 */
	protected function url( $file ) {
		return trailingslashit( FORTYTWO_WIDGETS_URL ) . trailingslashit( $this->slug ) . $file;
	}

	/**
	 * Return both the id and name attributes for a form field element.
	 *
	 * @since @@release
	 *
	 * @param string $field The field name.
	 */
	public function get_id_name( $field ) {
		return ' id="' . esc_attr( $this->get_field_id( $field ) ) . '" name="' . esc_attr( $this->get_field_name( $field ) ) . '"';
	}

	/**
	 * Echo both the id and name attributes for a form field element.
	 *
	 * @since @@release
	 *
	 * @see FT_Widget::get_id_name()
	 *
	 * @param string $field The field name.
	 */
	public function id_name( $field ) {
		echo $this->get_id_name( $field );
	}

	/**
	 * Get the default field names.
	 *
	 * @since @@release
	 *
	 * @return array Field names.
	 */
	public function get_fields() {
		return array_keys( $this->defaults );
	}

	/**
	 * Check each field of a widget instance to see if any are non-empty.
	 *
	 * @since @@release
	 *
	 * @param array $instance Widget instance settings.
	 *
	 * @return boolean True is at least one field is not empty, false otherwise.
	 */
	public function has_value( $instance ) {
		$has_value = false;
		foreach ( $instance as $field ) {
			if ( $field ) {
				$has_value = true;
				continue;
			}
		}

		if ( ! $has_value ) {
			return false;
		}

		return true;
	}
}
