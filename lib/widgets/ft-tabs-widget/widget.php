<?php
/**
 * FortyTwo Theme: Tabs Widget
 *
 * This file creates the Tabs Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 *
 * Copyright & Thanks
 *
 * Thanks to Woothemes for the inspiration for out Tabs  Widget.
 *
 */

class FT_Widget_Tabbed_Content extends FT_Widget {

	/**
	 * Widget slug / directory name.
	 *
	 * @var string
	 */
	protected $slug = 'ft-tabbed-content';

	/* Variable Declarations */
	public $fst_widget_cssclass;
	public $fst_widget_description;
	public $fst_widget_idbase;
	public $fst_widget_title;

	public $available_tabs;

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		/* Widget variable settings. */
		$this->fst_widget_cssclass    = 'ft-tabbed-content';
		$this->fst_widget_description = __( 'Tabbed content widget for the FortyTwo theme.', 'fortytwo' );
		$this->fst_widget_idbase      = 'widget-ft-tabbed-content';
		$this->fst_widget_title       = __( '42&nbsp;&nbsp;- Tabs', 'fortytwo' );

		$this->available_tabs = array( 'latest', 'popular', 'comments', 'tags' );
		// Allow child themes/plugins to filter here.
		$this->available_tabs = apply_filters( 'ft_available_tabbed_content', $this->available_tabs );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->fst_widget_cssclass, 'description' => $this->fst_widget_description );

		/* Widget control settings. */
		$control_ops = array( 'width' => 505, 'height' => 350, 'id_base' => $this->fst_widget_idbase );

		/* Create the widget. */
		$this->WP_Widget( $this->fst_widget_idbase, $this->fst_widget_title, $widget_ops, $control_ops );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );

	}

	/**
	 * Echo the widget content.
	 *
	 * @param array   $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array   $instance The settings for the particular instance of the widget
	 */
	public function widget( $args, $instance ) {
		$html = '';

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$tabs = $instance['tabs'];

		/* Before widget (defined by themes). */
		echo $args['before_widget'];

		include dirname( __FILE__ ) . '/views/widget.php';

		/* After widget (defined by themes). */
		echo $args['after_widget'];

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
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* The select box is returning a text value, so we escape it. */
		$instance['image_alignment'] = esc_attr( $new_instance['image_alignment'] );

		/* Escape the text string and convert to an integer. */
		$instance['limit'] = intval( strip_tags( $new_instance['limit'] ) );
		$instance['image_dimension'] = intval( strip_tags( $new_instance['image_dimension'] ) );

		/* Convert multiple tab_$position fields into tabs array */
		$instance['tabs'] = array();
		for ( $i = 0; $i < count( $this->available_tabs ); $i++ ) {
			$tab_value = $new_instance["tab_$i"];
			if ( $tab_value != 'none' ) {
				$instance['tabs'][] = $tab_value;
			}
		}

		// Allow child themes/plugins to act here.
		$instance = apply_filters( "{$this->fst_widget_idbase}_widget_save", $instance, $new_instance, $this );

		return $instance;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array   $instance Current settings
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		/* Make sure all keys are added here, even with empty string values. */
		$defaults = array(
			'title'           => __( 'Tabs', 'fortytwo' ),
			'tabs'            => array_slice( $this->available_tabs, 0, 3 ), /* default to selecting the first 3, to suggest that it is possible to omit having a tab */
			'limit'           => 5,
			'image_dimension' => 45,
			'image_alignment' => 'left',
		);

		// Allow child themes/plugins to filter here.
		$defaults = apply_filters( "{$this->fst_widget_idbase}_widget_defaults", $defaults, $this );
		$instance = wp_parse_args( (array)$instance, $defaults );
		$available_tabs = $this->available_tabs;

		include dirname( __FILE__ ) . '/views/form.php';

	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( 'ft-tabbed-content-admin-styles', $this->url( 'css/admin.css' ) );

	}

	/**
	 * Renders the latest content tab
	 *
	 * @param int $limit            The max number of content items to show
	 * @param int $image_dimension
	 * @param string $image_alignment The image alignment CSS class.  One of (???|???|???)
	 */
	public function tab_content_latest( $limit, $image_dimension, $image_alignment ) {
		global $post;
		$html = '';

		$html .= '<ul class="latest">' . "\n";
		$latest = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=post_date&order=desc' );
		foreach ( $latest as $post ) {
			setup_postdata( $post );
			$html .= '<li>' . "\n";
			if ( $image_dimension > 0 ) {
				$html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '" class="pull-' . $image_alignment . '">' . $this->get_image( $image_dimension, $post ) . '</a>' . "\n";
			}
			$html .= '<h4 class="entry-title"><a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a></h4>' . "\n";
			$html .= get_the_excerpt() . ' <a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">Read more</a>' . "\n";
			$html .= '</li>' . "\n";
		}
		$html .= '</ul>' . "\n";
		wp_reset_query();

		return $html;
	}

	/**
	 * Renders the popular content tab
	 *
	 * @param int $limit            The max number of content items to show
	 * @param int $image_dimension
	 * @param string $image_alignment The image alignment CSS class.  One of (???|???|???)
	 */
	public function tab_content_popular( $limit, $image_dimension, $image_alignment ) {
		global $post;
		$html = '';

		$html .= '<ul class="popular">' . "\n";
		$popular = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=comment_count&order=desc' );
		foreach ( $popular as $post ) {
			setup_postdata( $post );
			$html .= '<li>' . "\n";
			if ( $image_dimension > 0 ) {
				$html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '" class="pull-' . $image_alignment . '">' . $this->get_image( $image_dimension, $post ) . '</a>' . "\n";
			}
			$html .= '<h4 class="entry-title"><a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a></h4>' . "\n";
			$html .= get_the_excerpt() . ' <a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">Read more</a>' . "\n";
			$html .= '</li>' . "\n";
		}
		$html .= '</ul>' . "\n";
		wp_reset_query();

		return $html;
	}

	/**
	 * Renders the comments tab
	 *
	 * @param int $limit            The max number of comment items to show
	 * @param int $image_dimension
	 * @param string $image_alignment The image alignment CSS class.  One of (???|???|???)
	 */
	public function tab_content_comments( $limit, $image_dimension, $image_alignment ) {
		global $wpdb;
		$html = '';

		$comments = get_comments( array( 'number' => $limit, 'status' => 'approve' ) );
		if ( $comments ) {
			$html .= '<ul class="comments">' . "\n";
			foreach ( $comments as $c ) {
				$html .= '<li>' . "\n";
				$html .= '<span class="pull-' . $image_alignment . '">' . get_avatar( $c, 60 ) . '</span>';
				$html .= '<h4 class="entry-title"><a title="' . esc_attr( $c->comment_author . ' ' . __( 'on', 'fortytwo' ) . ' ' . get_the_title( $c->comment_post_ID ) ) . '" href="' . esc_url( get_comment_link( $c->comment_ID ) ) . '">' . esc_html( $c->comment_author ) . '</a></h4>' . "\n";
				$html .= '<span">' . stripslashes( substr( esc_html( $c->comment_content ), 0, 50 ) ) . '</span>' . "\n";
				$html .= '</li>' . "\n";
			}
			$html .= '</ul>' . "\n";
		}

		return $html;
	}

	/**
	 * Return default content for the content tab
	 *
	 * @return string
	 */
	public function tab_content_default( $token = '' ) {
		// noop
	}

	/**
	 * Returns an HTML fragment containing an <img> element for a post's image thumbnail
	 *
	 * @param int $image_dimension
	 * @param object $post  The post whose image thumbnail is being fetched
	 *
	 * @return string $html
	 */
	public function get_image( $dimension, $post ) {
		// TODO: This could use post type icon if no post thumbnail is supported
		//$html = '<img data-src="holder.js/' . $dimension . 'x' . $dimension .'" class="no-thumbnail wp-post-image hide">';

		if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) ) {
			$html = get_the_post_thumbnail( $post->ID, array( 'width' => $dimension, 'height' => $dimension, 'crop' => true ), array( 'class' => 'has-thumbnail' ) );
		}

		return $html;

	}


	/**
	 * Renders a tabs selection dropdown box
	 *
	 * @param array   $available_tabs An array of all the available tabs
	 * @param array   $selected_tabs  An array of the tabs that are currently selected
	 * @param int     $position       The position / order of the tab in the selected tabs
	 */
	protected function render_tabs_dropdown( $available_tabs, $selected_tabs, $position ) {
		echo '<p><select name="' . $this->get_field_name( 'tab_$position' ) . '"" class="widefat" id="' . $this->get_field_id( 'tab_$position' ) . '">';
		echo '<option value="none">' . __( ' - None selected - ', 'fortytwo' ) . '</option>';
		foreach ( $available_tabs as $available_tab ) {
			echo '<option value="' . esc_attr( $available_tab ) . '"' . selected( $available_tab, $selected_tabs[ $position ], false ) . '>' . __( $available_tab, 'fortytwo' ) . '</option>';
		}
		echo '</select></p>';
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Widget_Tabbed_Content");' ) );
