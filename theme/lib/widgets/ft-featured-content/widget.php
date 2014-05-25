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
	 * Instantiate the widget class.
	 */
	public function __construct() {
		$this->defaults = array(
			'title'       => '',
			'icon'        => '',
			'content'     => '',
			'link_text'   => '',
			'link_url'    => '',
		);

		parent::__construct(
			$this->slug,
			__( '42 - Featured Content', 'fortytwo', 'fortytwo-dev' ),
			array(
				'classname'   => 'widget-' . $this->slug,
				'description' => __( 'Featured Content widget for the FortyTwo Theme.', 'fortytwo', 'fortytwo-dev' )
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
		$instance = array();
		foreach ( array_keys( $this->defaults ) as $field ) {
			$instance[ $field ] = ( ! empty( $new_instance[ $field ] ) ) ? strip_tags( $new_instance[ $field ] ) : '';
		}

		return $instance;
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

add_action( 'widgets_init', 'ft_register_widget_featured_content' );
/**
 * Register the FT Featured Content widget.
 */
function ft_register_widget_featured_content() {
	register_widget( 'FT_Widget_Featured_Content' );
}
