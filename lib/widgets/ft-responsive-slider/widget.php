<?php
/*
	Description: A responsive featured slider for the Genesis Framework.
	Author: Forsite Themes
	Based on: Genesis Responsive Slider by StudioPress
	Author URI: http://forsitethemes.com
	Author Email: mail@forsitethemes.com
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Props to Rafal Tomal, Nick Croft, Nathan Rice, Ron Rennick, Josh Byers and Brian Gardner for collaboratively writing this plugin.
 */

/**
 * Thanks to Tyler Smith for creating the awesome jquery FlexSlider plugin - http://flex.madebymufffin.com/.
 */

define( 'FT_RESPONSIVE_SLIDER_SETTINGS_FIELD', 'ft_responsive_slider_settings' );
define( 'FT_RESPONSIVE_SLIDER_VERSION', '0.9.2' );

function ft_responsive_slider_url( $file ) {
	return FORTYTWO_WIDGETS_URL.'/ft-responsive-slider'.$file;
}

add_action( 'after_setup_theme', 'FTResponsiveSliderInit', 15 );
/**
 * Loads required files and adds image via Genesis Init Hook
 */
function FTResponsiveSliderInit() {

  // hook all frontend slider functions here to ensure Genesis is active **/
	add_action( 'wp_enqueue_scripts', 'ft_responsive_slider_scripts' );
//	add_action( 'wp_print_styles', 'ft_responsive_slider_styles' );
//	add_action( 'wp_head', 'ft_responsive_slider_head', 1 );
	add_action( 'wp_footer', 'ft_responsive_slider_flexslider_params' );
	add_action( 'widgets_init', 'ft_responsive_sliderRegister' );

	// Include Admin file 
	if ( is_admin() ) require_once dirname( __FILE__ ) . '/views/form.php';

	/* Add new image size */
	add_image_size( 'slider', ( int ) ft_get_responsive_slider_option( 'slideshow_width' ), ( int ) ft_get_responsive_slider_option( 'slideshow_height' ), TRUE );

}

add_action( 'genesis_settings_sanitizer_init', 'ft_responsive_slider_sanitization' );
/**
 * Add settings to Genesis sanitization
 *
 */
function ft_responsive_slider_sanitization() {
	genesis_add_option_filter( 'one_zero', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD,
		array(
			'slideshow_arrows',
			'slideshow_excerpt_show',
			'slideshow_title_show',
			'slideshow_loop',
			'slideshow_hide_mobile',
			'slideshow_no_link',
			'slideshow_pager'
		) );
	genesis_add_option_filter( 'no_html', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD,
		array(
			'post_type',
			'posts_term',
			'exclude_terms',
			'include_exclude',
			'post_id',
			'posts_num',
			'posts_offset',
			'orderby',
			'slideshow_timer',
			'slideshow_delay',
			'slideshow_height',
			'slideshow_width',
			'slideshow_effect',
			'slideshow_excerpt_content',
			'slideshow_excerpt_content_limit',
			'slideshow_more_text',
			'slideshow_excerpt_width',
			'location_vertical',
			'location_horizontal',
		) );
}

/**
 * Load the script files
 */
function ft_responsive_slider_scripts() {

	/* easySlider JavaScript code */
	wp_enqueue_script( 'flexslider', ft_responsive_slider_url( '/js/jquery.flexslider-min.js' ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, TRUE );

}

/**
 * Load the CSS files
 */
function ft_responsive_slider_styles() {

	/* standard slideshow styles */
	wp_register_style( 'slider_styles', ft_responsive_slider_url( '/css/style.css' ), array(), FT_RESPONSIVE_SLIDER_VERSION );
	wp_enqueue_style( 'slider_styles' );

}

/**
 * Loads scripts and styles via wp_head hook.
 */
function ft_responsive_slider_head() {

	$height = ( int ) ft_get_responsive_slider_option( 'slideshow_height' );
	$width = ( int ) ft_get_responsive_slider_option( 'slideshow_width' );

	$slideNavTop = ( int ) ( ( $height - 60 ) * .5 );

	$vertical = ft_get_responsive_slider_option( 'location_vertical' );
	$horizontal = ft_get_responsive_slider_option( 'location_horizontal' );
	$display = ( ft_get_responsive_slider_option( 'posts_num' ) >= 2 && ft_get_responsive_slider_option( 'slideshow_arrows' ) ) ? 'top: ' . $slideNavTop . 'px' : 'display: none';

	$slideshow_pager = ft_get_responsive_slider_option( 'slideshow_pager' ) ;

	echo '
		<style type="text/css">
			.slide-excerpt { ' . $vertical . ': 0; }
			.slide-excerpt { '. $horizontal . ': 0; }
			.flexslider { max-width: ' . $width . 'px; max-height: ' . $height . 'px; }
			.slide-image { max-height: ' . $height . 'px; }
		</style>';
}

/**
 * Outputs slider script on wp_footer hook.
 */
function ft_responsive_slider_flexslider_params() {

	$timer = ( int ) ft_get_responsive_slider_option( 'slideshow_timer' );
	$duration = ( int ) ft_get_responsive_slider_option( 'slideshow_delay' );
	$effect = ft_get_responsive_slider_option( 'slideshow_effect' );
	$controlnav = ft_get_responsive_slider_option( 'slideshow_pager' );
	$directionnav = ft_get_responsive_slider_option( 'slideshow_arrows' );

	$output = 'jQuery(document).ready(function($) {
				$(".slider-inner").flexslider({
					controlsContainer: ".ft-responsive-slider",
					animation: "' . esc_js( $effect ) . '",
					directionNav: ' . $directionnav . ',
					controlNav: ' . $controlnav . ',
					animationSpeed: ' . $duration . ',
					slideshowSpeed: ' . $timer . ',
					useCSS: false
			    });
			  });';

	$output = str_replace( array( "\n", "\t", "\r" ), '', $output );

	echo '<script type=\'text/javascript\'>' . $output . '</script>';
}

/**
 * Registers the slider widget
 */
function ft_responsive_sliderRegister() {
	register_widget( 'ft_responsive_sliderWidget' );
}

/* Creates read more link after excerpt */
function ft_responsive_slider_excerpt_more( $more ) {
	global $post;
	static $read_more = null;

	if ( $read_more === null )
		$read_more = ft_get_responsive_slider_option( 'slideshow_more_text' );

	if ( !$read_more )
		return '';

	return '&hellip; <a href="'. get_permalink( $post->ID ) . '">' . __( $read_more, 'fortytwo' ) . '</a>';
}

/**
 * Slideshow Widget Class
 */
class ft_responsive_sliderWidget extends WP_Widget {

	function ft_responsive_sliderWidget() {
		$widget_ops = array( 'classname' => 'ft-responsive-slider', 'description' => __( 'Displays a slideshow inside a widget area', 'fortytwo' ) );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'ftresponsiveslider-widget' );
		$this->WP_Widget( 'ftresponsiveslider-widget', __( 'FortyTwo - Responsive Slider', 'fortytwo' ), $widget_ops, $control_ops );
	}

	function save_settings( $settings ) {
		$settings['_multiwidget'] = 0;
		update_option( $this->option_name, $settings );
	}

	// display widget
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $title )
			echo $before_title . $title . $after_title;

		$term_args = array( );

		if ( 'page' != ft_get_responsive_slider_option( 'post_type' ) ) {

			if ( ft_get_responsive_slider_option( 'posts_term' ) ) {

				$posts_term = explode( ',', ft_get_responsive_slider_option( 'posts_term' ) );

				if ( 'category' == $posts_term['0'] )
					$posts_term['0'] = 'category_name';

				if ( 'post_tag' == $posts_term['0'] )
					$posts_term['0'] = 'tag';

				if ( isset( $posts_term['1'] ) )
					$term_args[$posts_term['0']] = $posts_term['1'];

			}

			if ( !empty( $posts_term['0'] ) ) {

				if ( 'category' == $posts_term['0'] )
					$taxonomy = 'category';

				elseif ( 'post_tag' == $posts_term['0'] )
					$taxonomy = 'post_tag';

				else
					$taxonomy = $posts_term['0'];

			} else {

				$taxonomy = 'category';

			}

			if ( ft_get_responsive_slider_option( 'exclude_terms' ) ) {

				$exclude_terms = explode( ',', str_replace( ' ', '', ft_get_responsive_slider_option( 'exclude_terms' ) ) );
				$term_args[$taxonomy . '__not_in'] = $exclude_terms;

			}
		}

		if ( ft_get_responsive_slider_option( 'posts_offset' ) ) {
			$myOffset = ft_get_responsive_slider_option( 'posts_offset' );
			$term_args['offset'] = $myOffset;
		}

		if ( ft_get_responsive_slider_option( 'post_id' ) ) {
			$IDs = explode( ',', str_replace( ' ', '', ft_get_responsive_slider_option( 'post_id' ) ) );
			if ( 'include' == ft_get_responsive_slider_option( 'include_exclude' ) )
				$term_args['post__in'] = $IDs;
			else
				$term_args['post__not_in'] = $IDs;
		}

		$query_args = array_merge( $term_args, array(
				'post_type' => ft_get_responsive_slider_option( 'post_type' ),
				'posts_per_page' => ft_get_responsive_slider_option( 'posts_num' ),
				'orderby' => ft_get_responsive_slider_option( 'orderby' ),
				'order' => ft_get_responsive_slider_option( 'order' ),
				'meta_key' => ft_get_responsive_slider_option( 'meta_key' )
			) );

		$query_args = apply_filters( 'ft_responsive_slider_query_args', $query_args );
		add_filter( 'excerpt_more', 'ft_responsive_slider_excerpt_more' );

?>

		<div class="slider-inner">
			<ul class="slides">
				<?php
	$slider_posts = new WP_Query( $query_args );
	if ( $slider_posts->have_posts() ) {
		$show_excerpt = ft_get_responsive_slider_option( 'slideshow_excerpt_show' );
		$show_title = ft_get_responsive_slider_option( 'slideshow_title_show' );
		$show_type = ft_get_responsive_slider_option( 'slideshow_excerpt_content' );
		$show_limit = ft_get_responsive_slider_option( 'slideshow_excerpt_content_limit' );
		$more_text = ft_get_responsive_slider_option( 'slideshow_more_text' );
		$no_image_link = ft_get_responsive_slider_option( 'slideshow_no_link' );

		$slide_excerpt_col = ( int ) ft_get_responsive_slider_option( 'slideshow_excerpt_width' );
		$slide_image_col = 12 - $slide_excerpt_col;

		if ( ft_get_responsive_slider_option( 'slideshow_hide_mobile' ) == 1 ) {
			$hide_mobile = array(
				'hide_excerpt'   => ' hidden-xs',
				'add_image_cols' => ' col-xs-12'
			);
		} else {
			$hide_mobile = array(
				'hide_excerpt'   => '',
				'add_image_cols' => ''
			);
		}

	}
				while ( $slider_posts->have_posts() ) : $slider_posts->the_post();
					?>
					<li class="slide-<?php the_ID(); ?>">

					<?php if ( $show_excerpt == 1 || $show_title == 1 ) { ?>
						<div class="slide-excerpt col-<?php echo $slide_excerpt_col ?><?php echo $hide_mobile['hide_excerpt'] ?>">
							<?php
							if ( $show_title == 1 ) {
								?>
								<h2><a href="<?php the_permalink() ?>"
									   rel="bookmark"><?php the_title(); ?></a></h2>
							<?php
							}
							if ( $show_excerpt ) {
								if ( $show_type != 'full' )
									the_excerpt();
								elseif ( $show_limit )
									the_content_limit( (int)$show_limit, esc_html( $more_text ) ); else
									the_content( esc_html( $more_text ) );
							}
							?>
						</div>
					<?php } ?>

						<div class="slide-image col-<?php echo $slide_image_col ?><?php echo $hide_mobile['add_image_cols'] ?>">
							<?php
							if ( $no_image_link ) {
								?>
								<img src="<?php genesis_image( 'format=url&size=slider' ); ?>"
									 alt="<?php the_title(); ?>"/>
							<?php
							} else {
								?>
								<a href="<?php the_permalink() ?>" rel="bookmark"><img
										src="<?php genesis_image( 'format=url&size=slider' ); ?>"
										alt="<?php the_title(); ?>"/></a>
							<?php

							}
							?>
						</div>

					</li>
				<?php endwhile; ?>
			</ul>
		</div>

<?php
		echo $after_widget;
		wp_reset_query();
		remove_filter( 'excerpt_more', 'ft_responsive_slider_excerpt_more' );

	}

	/* Widget options */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
<?php
		echo '<p>';
		printf( __( 'To configure slider options, please go to the <a href="%s">Slider Settings</a> page.', 'fortytwo' ), menu_page_url( 'genesis_responsive_slider', 0 ) );
		echo '</p>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '' ) );
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

}

/**
 * Used to exclude taxonomies and related terms from list of available terms/taxonomies in widget form().
 *
 * @since 0.9
 * @author Nick Croft
 *
 * @param string  $taxonomy 'taxonomy' being tested
 * @return string
 */
function ft_responsive_slider_exclude_taxonomies( $taxonomy ) {

	$filters = array( '', 'nav_menu' );
	$filters = apply_filters( 'ft_responsive_slider_exclude_taxonomies', $filters );

	return ! in_array( $taxonomy->name, $filters );

}

/**
 * Used to exclude post types from list of available post_types in widget form().
 *
 * @since 0.9
 * @author Nick Croft
 *
 * @param string  $type 'post_type' being tested
 * @return string
 */
function ft_responsive_slider_exclude_post_types( $type ) {

	$filters = array( '', 'attachment' );
	$filters = apply_filters( 'ft_responsive_slider_exclude_post_types', $filters );

	return ! in_array( $type, $filters );

}

/**
 * Returns Slider Option
 *
 * @param string  $key key value for option
 * @return string
 */
function ft_get_responsive_slider_option( $key ) {
	return genesis_get_option( $key, FT_RESPONSIVE_SLIDER_SETTINGS_FIELD );
}

/**
 * Echos Slider Option
 *
 * @param string  $key key value for option
 */
function ft_responsive_slider_option( $key ) {

	if ( ! ft_get_responsive_slider_option( $key ) )
		return false;

	echo ft_get_responsive_slider_option( $key );
}
