<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
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
	 * Instantiate the widget class.
	 */
	public function __construct() {
		$this->defaults = array(
			'title'          => '',
			'content'        => '',
			'link_text'      => '',
			'link_url'       => '',
		);

		parent::__construct(
			$this->slug,
			__( '42 - Jumbotron', 'fortytwo' ),
			array(
				'classname'   => 'widget-' . $this->slug,
				'description' => __( 'Jumbotron widget for the FortyTwo Theme.', 'fortytwo' )
			)
		);
	}

	/**
	 * Update a particular instance.
	 * 
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form().
	 * @param array $old_instance Old settings for this instance.
	 * 
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		foreach ( $this->get_fields() as $field ) {
			$instance[ $field ] = ( ! empty( $new_instance[ $field ] ) ) ? strip_tags( $new_instance[ $field ] ) : '';
		}

		return $instance;

	}
}

add_action( 'widgets_init', 'ft_register_widget_jumbotron' );
/**
 * Register the FT Jumbotron widget.
 */
function ft_register_widget_jumbotron() {
	register_widget( 'FT_Widget_Jumbotron' );
}
