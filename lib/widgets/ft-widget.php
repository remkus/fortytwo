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
}
