<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
if ( $instance['title'] ) {
	echo $args['before_title'] . $instance['title'] . $args['after_title'];
}
?>
<div class="<?php echo $this->get_field_id( 'container' )?> slider-inner invisible">
	<ul class="slides">
	<?php
		while ( $slider_posts->have_posts() ):
			$slider_posts->the_post();
			?>
		<li class="slide-<?php the_ID(); ?>">
		<?php
			if ( $show_excerpt == 1 || $show_title == 1 ) {
		?>
			<div class="slide-excerpt <?php echo sanitize_html_class( $hide_mobile['hide_excerpt'] ); ?>">
			<?php
				if ( $show_title == 1 ) {
			?>
				<h2>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			<?php
				}

				if ( $show_excerpt ) {
					if ( $show_type != 'full' ) {
						the_excerpt();
					} elseif ( $show_limit ) {
						the_content_limit( (int)$show_limit, esc_html( $more_text ) );
					} else {
						the_content( esc_html( $more_text ) );
					}
				}
			?>
			</div>
			<?php
			}
			?>
			<div class="slide-image">
			<?php
				$image_url = ( genesis_get_image( 'format=url' ) !== false ? genesis_get_image( 'format=url' ) : get_bloginfo( 'stylesheet_directory' ) . '/images/no-image.png' );
				if ( $no_image_link ) {
			?>
				<img src="<?php echo esc_url( wpthumb( $image_url, array( 'width' => $slide_image_width, 'height' => $slide_image_height, 'crop' => true, ) ) ); ?>" alt="<?php esc_attr( the_title() ); ?>" />
			<?php
				} else {
			?>
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<img src="<?php echo esc_url( wpthumb( $image_url, array( 'width' => $slide_image_width, 'height' => $slide_image_height, 'crop' => true, ) ) ); ?>" alt="<?php esc_attr( the_title() ); ?>"/>
				</a>
			<?php
				}
			?>
			</div>
		</li>
	<?php
		endwhile;
	?>
	</ul>
	<?php
		$controlsContainer = ".{$this->get_field_id( 'container' )}.slider-inner";
		$timer             = (int) $this->get_value( 'slideshow_timer' );
		$duration          = (int) $this->get_value( 'slideshow_delay' );
		$effect            = $this->get_value( 'slideshow_effect' );
		$controlnav        = $this->get_value( 'slideshow_pager' );
		$directionnav      = $this->get_value( 'slideshow_arrows' );
	?>
	<script>
		jQuery( document ).ready( function( $ ) {
			'use strict';
			$( '<?php echo $controlsContainer; ?>' ).flexslider({
				controlsContainer: '<?php echo $controlsContainer; ?>',
				animation: '<?php echo esc_js( $effect ); ?>',
				directionNav: '<?php echo $directionnav; ?>',
				controlNav: '<?php echo $controlnav; ?>',
				animationSpeed: '<?php echo $duration; ?>',
				slideshowSpeed: '<?php echo $timer; ?>',
				prevText: '<i class="ft-ico ft-ico-prev"></i>',
				nextText: '<i class="ft-ico ft-ico-next"></i>',
				useCSS: false,
				start: function( slider ){
					var arr = [ 'slider-inner', 'slider-nav' ];
					$.each( arr, function() {
						$( '.' + this ).removeClass( 'invisible' );
					});
				}
		    });
		});
	</script>
</div>
