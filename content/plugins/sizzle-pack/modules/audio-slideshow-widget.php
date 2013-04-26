<?php
/**
 * A slideshow widget
 *
 * @package Genesis
 * @copyright CoDrop -> http://tympanus.net/codrops/2012/04/24/audio-slideshow-with-jplayer/
 * @license GPL v2
 */

require_once SZZL_PACK_DIR . '/modules/slideshow-widget/genesis-responsive-slider-datasource.php';

/**
 * ForSite Themes Audio Slideshow widget class.
 *
 * @package Genesis
 * @subpackage Widgets
 * @since 0.1
 */
class SZZL_Audio_Slideshow_Widget extends WP_Widget {

	/* Properties */
	var $library_url;
	var $version = "0.0.1";
	/**
	 * Source of posts to be displayed.  Can be one of many implementations, depending on slider backend in use.
	 */
	var $slider_datasource;

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function SZZL_Audio_Slideshow_Widget() {
		$this->library_url = SZZL_PACK_URL."widgets/audio-slideshow-widget/";
		$this->enqueue_styles();
		$this->enqueue_scripts();

		//TODO:  Init the appropriate datasource based on which other slider backend is available
		$this->slider_datasource = new Genesis_Responsive_Slider_Datasource();

		$widget_ops = array(
			'classname' => 'szzl-audio-slideshow-widget',
			'description' => __( 'Forsite Themes Extension Pack Audio slideshow widget', 'SZZL_slideshow' )
		);

		$this->WP_Widget( 'szzl-audio-slideshow-widget', __( 'SZZL - Audio Slideshow', 'SZZL_audio_slideshow' ), $widget_ops );
	}

	/**
	 * Enqueue the styles required for the widget.
	 */
	function enqueue_styles() {
		wp_enqueue_style( "SZZL_Audio_Slideshow_Widget_style", $this->library_url . 'css/style.css', array(), $this->version );
	}

	/**
	 * Enqueue the scripts required for the widget.
	 */
	function enqueue_scripts() {
		wp_enqueue_script( "SZZL_Audio_Slideshow_Widget_jplayer", $this->library_url . 'jplayer/jquery.jplayer.js', array( 'jquery' ), $this->version );
		wp_enqueue_script( "SZZL_Audio_Slideshow_Widget_audioslideshow", $this->library_url . 'js/jquery.audioslideshow.js', array( 'SZZL_Audio_Slideshow_Widget_jplayer' ), $this->version );
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
        <div class="audio-slideshow" data-audio="<?php echo $this->library_url ?>Kurt_Vile_-_01_-_Freeway.mp3" data-audio-duration="161">
            <div class="audio-slides">
                <?php
		$post_counter=0;
		while ( $slider_posts["posts"]->have_posts() ) :
			$slider_posts["posts"]->the_post();
		$post_counter++;
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail" );
?>
                    <div data-thumbnail="<?php echo $thumbnail[0] ?>" data-slide-time="<?php echo $post_counter*10; ?>">
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
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="audio-control-interface">
                <div class="play-pause-container">
                   	<a href="javascript:;" class="audio-play" tabindex="1">Play</a>
                        <a href="javascript:;" class="audio-pause" tabindex="1">Pause</a>
                </div>
                <div class="time-container">
                        <span class="play-time"></span> / <span class="total-time"></span>
                </div>
                <div class="timeline">
                        <div class="timeline-controls"></div>
                        <div class="playhead"></div>
                </div>
                <div class="jplayer"></div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(function($) {
                $('.audio-slideshow').audioSlideshow();
            });
        </script>
        <!-- end audio-slideshow-->
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
