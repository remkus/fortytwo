<?php
/**
 * A slideshow widget
 *
 * @package Genesis
 * @copyright CoDrop -> http://tympanus.net/codrops/2012/04/05/slideshow-with-jmpress-js/
 * @license GPL v2
 */

require_once SZZL_PACK_DIR . '/modules/slideshow-widget/genesis-responsive-slider-datasource.php';

/**
 * ForSite Themes Slideshow widget class.
 *
 * @package Genesis
 * @subpackage Widgets
 * @since 0.1cd www
 */
class SZZL_Slideshow_Widget extends WP_Widget {

	/* Properties */
	var $library_url;
	var $version = "0.0.1";
	/*
     * Source of posts to be displayed.  Can be one of many implementations, depending on slider backend in use.
     */
	var $slider_datasource;

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function SZZL_Slideshow_Widget() {
		$this->library_url = SZZL_PACK_URL."modules/slideshow-widget/";
		$this->enqueue_styles();
		$this->enqueue_scripts();

		//TODO:  Init the appropriate datasource based on which other slider backend is available
		$this->slider_datasource = new Genesis_Responsive_Slider_Datasource();

		$widget_ops = array (
			'classname' => 'szzl-slideshow-widget',
			'description' => __( 'Forsite Themes Extension Pack slideshow widget', 'SZZL_slideshow' )
                );
		$this->WP_Widget( 'fstslideshow-widget', __( 'SZZL - Slideshow', 'SZZL_slideshow' ), $widget_ops );
	}

	/**
	 * Enqueue the styles required for the widget.
	 */
	function enqueue_styles() {
		global $wp_styles;
		wp_enqueue_style( "SZZL_Slideshow_Widget_style", $this->library_url . 'css/style.css', array(), $this->version );
		wp_enqueue_style( 'SZZL_Slideshow_Widget_style_ie', $this->library_url . 'css/style_ie.css', array( "SZZL_Slideshow_Widget_style" ), $this->version );
		$wp_styles->add_data( 'SZZL_Slideshow_Widget_style_ie', 'conditional', 'lte IE 9' ); //ie stylesheet should be wrapped in <!--[if lt IE 9]>
	}

	/**
	 * Enqueue the scripts required for the widget.
	 */
	function enqueue_scripts() {
		wp_enqueue_script( "SZZL_Slideshow_Widget_jmpress", $this->library_url . 'js/jmpress.min.js', array( 'jquery' ), $this->version );
		wp_enqueue_script( "SZZL_Slideshow_Widget_jmslideshow", $this->library_url . 'js/jquery.jmslideshow.js', array( 'SZZL_Slideshow_Widget_jmpress' ), $this->version );
		wp_enqueue_script( "SZZL_Slideshow_Widget_modernizr", $this->library_url . 'js/modernizr.custom.48780.js', array( 'SZZL_Slideshow_Widget_jmslideshow' ), $this->version );
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array   $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array   $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		extract( $args );


		echo $before_widget;

		if ( $instance['name'] != '' ) {
			echo $before_title . $instance['name'] . $after_title;
		}

		$slider_posts = $this->slider_datasource->get_slider_posts();
?>
        <section id="jms-slideshow" class="jms-slideshow">
<?php $post_counter=0; while ( $slider_posts["posts"]->have_posts() ) : $slider_posts["posts"]->the_post(); $post_counter++?>
        <div class="step" data-color="color-<?php echo $post_counter;?>" data-template="step<?php echo $post_counter;?>">
            <div class="jms-content">
                <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                <?php
		if ( $slider_posts["show_excerpt"] ) {
			if ( $slider_posts["show_type"] != 'full' )
				the_content_limit( 55, '' );
			elseif ( $slider_posts["show_limit"] )
				the_content_limit( (int)$slider_posts["show_limit"], '' );
			else
				the_content( '' );
		}
?>
                <a class="jms-link" href="<?php the_permalink() ?>"><?php echo esc_html( $slider_posts["more_text"] ) ?></a>
            </div>
            <?php the_post_thumbnail(); ?>
        </div>
<?php endwhile; ?>
        </section>
        <script type="text/javascript">
            jQuery(function($) {
                $.jmpress("template", "step1", { });
                $.jmpress("template", "step2", { y: 500, scale: 0.4, "rotate-x": 30 });
                $.jmpress("template", "step3", { y: 2000, z: 3000, "rotate": 170 });
                $.jmpress("template", "step4", { x: 3000 });
                $.jmpress("template", "step5", { x: 4500, z: 1000, "rotate-y": 45 });

                $( '#jms-slideshow' ).jmslideshow();

            });
        </script>
        <!-- end .slideshow-->
<?php
		echo $after_widget;
		wp_reset_query();
	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array   $new_instance New settings for this instance as input by the user via form()
	 * @param array   $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {
		$new_instance = $old_instance;
		return $new_instance;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array   $instance Current settings
	 */
	function form( $instance ) {

	}

}
