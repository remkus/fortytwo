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
	 * Instantiate the widget class.
	 */
	public function __construct() {
		$this->defaults = array(
			'title'            => '',
			'content'          => '',
			'button_alignment' => 'right',
			'button_text'      => '',
			'button_link'      => '',
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
