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
}
