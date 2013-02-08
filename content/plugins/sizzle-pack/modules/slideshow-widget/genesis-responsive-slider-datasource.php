<?php
require_once FST_PACK_DIR . '/modules/slideshow-widget/slider-datasource.php';

/**
 * Grabs a list of posts to display in the slider based on 
 * the Genesis Responsive Slider admin screen settings.
 *
 * @author mrdavidlaing
 */
class Genesis_Responsive_Slider_Datasource extends Slider_Datasource {
    
    /*
     * Returns list of slider posts to display, based on Genesis Responsive Slider 
     * admin settings.
     */
    function get_slider_posts() {
        $term_args = array( );

        if ( 'page' != genesis_get_responsive_slider_option( 'post_type' ) ) {

                if ( genesis_get_responsive_slider_option( 'posts_term' ) ) {

                        $posts_term = explode( ',', genesis_get_responsive_slider_option( 'posts_term' ) );

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

                if ( genesis_get_responsive_slider_option( 'exclude_terms' ) ) {

                        $exclude_terms = explode( ',', str_replace( ' ', '', genesis_get_responsive_slider_option( 'exclude_terms' ) ) );
                        $term_args[$taxonomy . '__not_in'] = $exclude_terms;

                }
        }

        if ( genesis_get_responsive_slider_option( 'posts_offset' ) ) {
                $myOffset = genesis_get_responsive_slider_option( 'posts_offset' );
                $term_args['offset'] = $myOffset;
        }

        if ( genesis_get_responsive_slider_option( 'post_id' ) ) {
                $IDs = explode( ',', str_replace( ' ', '', genesis_get_responsive_slider_option( 'post_id' ) ) );
                if ( 'include' == genesis_get_responsive_slider_option( 'include_exclude' ) )
                        $term_args['post__in'] = $IDs;
                else
                        $term_args['post__not_in'] = $IDs;
        }

        $query_args = array_merge( $term_args, array(
                'post_type' => genesis_get_responsive_slider_option( 'post_type' ),
                'posts_per_page' => genesis_get_responsive_slider_option( 'posts_num' ),
                'orderby' => genesis_get_responsive_slider_option( 'orderby' ),
                'order' => genesis_get_responsive_slider_option( 'order' ),
                'meta_key' => genesis_get_responsive_slider_option( 'meta_key' )
        ) );

        $query_args = apply_filters( 'genesis_responsive_slider_query_args', $query_args );
        
        $slider_posts = new WP_Query( $query_args );
        if ( $slider_posts->have_posts() ) {
                $show_excerpt = genesis_get_responsive_slider_option( 'slideshow_excerpt_show' );
                $show_title = genesis_get_responsive_slider_option( 'slideshow_title_show' );
                $show_type = genesis_get_responsive_slider_option( 'slideshow_excerpt_content' );
                $show_limit = genesis_get_responsive_slider_option( 'slideshow_excerpt_content_limit' );
                $more_text = genesis_get_responsive_slider_option( 'slideshow_more_text' );
        } 
        
        return array(
              "posts" => $slider_posts
            , "show_excerpt" => $show_excerpt
            , "show_title" => $show_title
            , "show_type" => $show_type
            , "show_limit" => $show_limit
            , "more_text" => $more_text
        );
    }
}

?>
