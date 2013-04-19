<?php
/*
 WARNING: This file is part of the core Genesis framework. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Handles display of 404 page.
 *
 * This file is a core Genesis file and should not be edited.
 *
 * @category Genesis
 * @package  Templates
 * @author   StudioPress
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.studiopress.com/themes/genesis
 */

/** Remove default loop **/
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() { 
	
	genesis_markup( '<article class="entry">', '<div class="post hentry"' );
		printf( '<h1 class="entry-title">%s</h1>', __( 'Not found, error 404', 'genesis' ) );
		echo '<div class="entry-content">';
		
			if ( current_theme_supports( 'genesis-html5' ) ) :

				echo '<p>' . sprintf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis' ), home_url() ) . '</p>';
				
				echo '<p>' . get_search_form() . '</p>';
			
			else :
	?>

			<p><?php printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'genesis' ), home_url() ); ?></p>

			<h4><?php _e( 'Pages:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_pages( 'title_li=' ); ?>
			</ul>

			<h4><?php _e( 'Categories:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
			</ul>

			<h4><?php _e( 'Authors:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
			</ul>

			<h4><?php _e( 'Monthly:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>

			<h4><?php _e( 'Recent Posts:', 'genesis' ); ?></h4>
			<ul>
				<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
			</ul>

<?php
			endif;
			
			echo '</div>';
		genesis_markup( '</article>', '</div>' );

}

genesis();
