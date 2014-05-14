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

abstract class FT_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults.
	 *
	 * @var array
	 */
	protected $defaults;

	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {
		$hooks = array(
			'admin_enqueue_scripts' => array( 'admin_styles', 'admin_scripts', ),
			'wp_enqueue_scripts'    => array( 'widget_styles', 'widget_scripts', ),
		);

		foreach ( $hooks as $hook => $methods ) {
			foreach ( $methods as $method ) {
				if ( method_exists( $this, $method ) ) {
					add_action( $hook, array( $this, $method ) );
				}
			}
		}

		$this->defaults = apply_filters( "{$this->slug}_widget_defaults", $this->defaults );

		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	/**
	 * Return an absolute URL to a file relative to the widget's folder
	 *
	 * @param string $file The file path (relative to the widget's folder).
	 *
	 * @return string
	 */
	protected function url( $file ) {
		// $reflection = new ReflectionClass( $this );
		// $directory  = basename( dirname( $reflection->getFileName() ) );
		// return trailingslashit( FORTYTWO_WIDGETS_URL ) . trailingslashit( $directory ) . $file;
		return trailingslashit( FORTYTWO_WIDGETS_URL ) . trailingslashit( $this->slug ) . $file;
	}

	/**
	 * Set a default value for an empty variable.
	 *
	 * @param mixed $value   The variable whose default should be set.
	 *                       
	 * @param mixed $default The default value.
	 */
	protected function set_default( &$value, $default ) {
		if ( empty ( $value ) ) {
			$value = $default;
		}
	}

	/**
	 * Return both the id and name attributes for a form field element.
	 *
	 * @param string $field The field name.
	 */
	public function get_id_name( $field ) {
		return ' id="' . esc_attr( $this->get_field_id( $field ) ) . '" name="' . esc_attr( $this->get_field_name( $field ) ) . '"';
	}

	/**
	 * Echo both the id and name attributes for a form field element.
	 *
	 * @see FT_Widget::get_id_name()
	 *
	 * @param string $field The field name.
	 */
	public function id_name( $field ) {
		echo $this->get_id_name( $field );
	}

	public function get_fields() {
		return array_keys( $this->defaults );
	}
}