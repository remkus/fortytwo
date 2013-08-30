<?php
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

		<div class="slider-inner invisible">
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

	$controlnav = ft_get_responsive_slider_option( 'slideshow_pager' );
	$directionnav = ft_get_responsive_slider_option( 'slideshow_arrows' );

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
						<div class="slide-excerpt col-lg-<?php echo $slide_excerpt_col ?><?php echo $hide_mobile['hide_excerpt'] ?>">
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

						<div class="slide-image col-lg-<?php echo $slide_image_col ?><?php echo $hide_mobile['add_image_cols'] ?>">
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
