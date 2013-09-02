<div class="slider-inner invisible">
	<ul class="slides">
		<?php while ( $slider_posts->have_posts() ) : $slider_posts->the_post(); ?>
			<li class="slide-<?php the_ID(); ?>">
			<?php if ( $show_excerpt == 1 || $show_title == 1 ) { ?>
				<div class="slide-excerpt col-lg-<?php echo $slide_excerpt_col ?><?php echo $hide_mobile['hide_excerpt'] ?>">
					<?php if ( $show_title == 1 ) { ?>
						<h2><a href="<?php the_permalink() ?>"
							   rel="bookmark"><?php the_title(); ?></a></h2>
					<?php }
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
				<div class="slide-image col-lg-<?php echo $slide_image_col ?><?php echo $hide_mobile['add_image_cols'] ?>">
					<?php if ( $no_image_link ) { ?>
						<img src="<?php genesis_image( 'format=url&size=slider' ); ?>"
							 alt="<?php the_title(); ?>"/>
					<?php } else { ?>
						<a href="<?php the_permalink() ?>" rel="bookmark"><img
								src="<?php genesis_image( 'format=url&size=slider' ); ?>"
								alt="<?php the_title(); ?>"/></a>
					<?php } ?>
				</div>
			</li>
		<?php endwhile; ?>
	</ul>
</div>
