<?php
/**
 * Controls output elements in comment sections.
 *
 * @category   Genesis
 * @package    Structure
 * @subpackage Comments
 * @author     StudioPress
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://www.studiopress.com/themes/genesis
 */

add_action( 'genesis_after_post', 'genesis_get_comments_template' );
add_action( 'genesis_after_entry', 'genesis_get_comments_template' );
/**
 * Output the comments at the end of posts / pages.
 *
 * Load comments only if we are on a page or post and only if comments or
 * trackbacks are enabled.
 *
 * @since 1.1.0
 *
 * @global WP_Post $post Post object. 
 * @uses genesis_get_option()
 */
function genesis_get_comments_template() {

	global $post;

	if ( ! post_type_supports( $post->post_type, 'comments' ) )
		return;

	if ( is_singular() && ! in_array( $post->post_type, array( 'post', 'page' ) ) )
		comments_template( '', true );
	elseif ( is_singular( 'post' ) && ( genesis_get_option( 'trackbacks_posts' ) || genesis_get_option( 'comments_posts' ) ) )
		comments_template( '', true );
	elseif ( is_singular( 'page' ) && ( genesis_get_option( 'trackbacks_pages' ) || genesis_get_option( 'comments_pages' ) ) )
		comments_template( '', true );

}

add_action( 'genesis_comments', 'genesis_do_comments' );
/**
 * Echo Genesis default comment structure.
 *
 * @since 1.1.2
 *
 * @uses genesis_get_option()
 *
 * @global WP_Post $post Post object.
 * @global WP_Query $wp_query Query object.
 * @return null Returns early if on a page with Genesis pages comments off, or a post and Genesis posts comments off.
 */
function genesis_do_comments() {

	global $post, $wp_query;

	/** Bail if comments are off for this post type */
	if ( ( is_page() && ! genesis_get_option( 'comments_pages' ) ) || ( is_single() && ! genesis_get_option( 'comments_posts' ) ) )
		return;

	if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) {

		genesis_markup( array(
			'html5'   => '<div %s>',
			'xhtml'   => '<div id="comments">',
			'context' => 'entry-comments',
		) );

			echo apply_filters( 'genesis_title_comments', __( '<h3>Comments</h3>', 'genesis' ) );
			echo '<ol class="comment-list">';
				do_action( 'genesis_list_comments' );
			echo '</ol>';

			//** Comment Navigation
			$prev_link = get_previous_comments_link( apply_filters( 'genesis_prev_comments_link_text', '' ) );
			$next_link = get_next_comments_link( apply_filters( 'genesis_next_comments_link_text', '' ) );
		
			if ( $prev_link || $next_link )
				printf( '<div class="navigation"><div class="alignleft">%s</div><div class="alignright">%s</div></div>', $prev_link, $next_link );

		echo '</div>';

	}
	/** No comments so far */
	elseif ( 'open' == $post->comment_status && $no_comments_text = apply_filters( 'genesis_no_comments_text', '' ) ) { 
		genesis_markup( array(
			'html5'   => '<div %s>' . $no_comments_text . '</div>',
			'xhtml'   => '<div id="comments">' . $no_comments_text . '</div>',
			'context' => 'entry-comments',
		) );
	}
	elseif ( $comments_closed_text = apply_filters( 'genesis_comments_closed_text', '' ) ) {
		genesis_markup( array(
			'html5'   => '<div %s>' . $comments_closed_text . '</div>',
			'xhtml'   => '<div id="comments">' . $comments_closed_text . '</div>',
			'context' => 'entry-comments',
		) );
	}

}

add_action( 'genesis_pings', 'genesis_do_pings' );
/**
 * Echo Genesis default trackback structure.
 *
 * @since 1.1.2
 *
 * @uses genesis_get_option()
 *
 * @global WP_Query $wp_query Query object
 * @return null Returns early if on a page with Genesis pages trackbacks off, or a post and Genesis posts trackbacks off.
 */
function genesis_do_pings() {
	global $wp_query;

	/** Bail if trackbacks are off for this post type */
	if ( ( is_page() && ! genesis_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! genesis_get_option( 'trackbacks_posts' ) ) )
		return;

	/** If have pings */
	if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {
		?>
		<div id="pings">
			<?php echo apply_filters( 'genesis_title_pings', __( '<h3>Trackbacks</h3>', 'genesis' ) ); ?>
			<ol class="ping-list">
				<?php do_action( 'genesis_list_pings' ); ?>
			</ol>
		</div><!-- end #pings -->
		<?php
	}
	/** No pings so far */
	else {
		echo apply_filters( 'genesis_no_pings_text', '' );
	}

}

add_action( 'genesis_list_comments', 'genesis_default_list_comments' );
/**
 * Outputs the comment list to the <code>genesis_comment_list()</code> hook.
 *
 * @since 1.0.0
 */
function genesis_default_list_comments() {

	$defaults = array(
		'type'        => 'comment',
		'avatar_size' => 48,
		'format'      => 'html5', //** Not necessary, but a good example
		'callback'    => current_theme_supports( 'genesis-html5' ) ? 'genesis_html5_comment_callback' : 'genesis_comment_callback',
	);

	$args = apply_filters( 'genesis_comment_list_args', $defaults );

	wp_list_comments( $args );

}

add_action( 'genesis_list_pings', 'genesis_default_list_pings' );
/**
 * Outputs the ping list to the <code>genesis_ping_list()</code> hook.
 *
 * @since 1.0.0
 */
function genesis_default_list_pings() {

	$args = apply_filters( 'genesis_ping_list_args', array(
		'type' => 'pings',
	) );

	wp_list_comments( $args );

}

/**
 * Comment callback for {@link genesis_default_comment_list()} if HTML5 is not active.
 *
 * @since 1.0.0
 *
 * @param stdClass $comment
 * @param array $args
 * @param integer $depth
 */
function genesis_comment_callback( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

		<?php do_action( 'genesis_before_comment' ); ?>

		<div class="comment-header">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<?php printf( __( '<cite class="fn">%s</cite> <span class="says">%s:</span>', 'genesis' ), get_comment_author_link(), apply_filters( 'comment_author_says_text', __( 'says', 'genesis' ) ) ); ?>
		 	</div><!-- end .comment-author -->

			<div class="comment-meta commentmetadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s', 'genesis' ), get_comment_date(), get_comment_time() ); ?></a>
				<?php edit_comment_link( __( '(Edit)', 'genesis' ), '' ); ?>
			</div><!-- end .comment-meta -->
		</div>

		<div class="comment-content">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="alert"><?php echo apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div><!-- end .comment-content -->

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>

		<?php do_action( 'genesis_after_comment' );

	/** No ending </li> tag because of comment threading */

}

/**
 * Comment callback for {@link genesis_default_comment_list()} if HTML5 is active.
 *
 * @since 2.0.0
 *
 * @param stdClass $comment
 * @param array $args
 * @param integer $depth
 */
function genesis_html5_comment_callback( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article <?php echo genesis_attr( 'comment' ); ?>>

		<?php do_action( 'genesis_before_comment' ); ?>

		<header class="comment-header">
			<p <?php echo genesis_attr( 'comment-author' ); ?>>
				<?php
				echo get_avatar( $comment, $args['avatar_size'] );

				$author = get_comment_author();
				$url    = get_comment_author_url();

				if ( ! empty( $url ) && 'http://' != $url ) {
					$author = sprintf( '<a href="%s" rel="external nofollow" itemprop="url">%s</a>', esc_url( $url ), $author );
				}

				printf( '<span itemprop="name">%s</span> <span class="says">%s</span>', $author, apply_filters( 'comment_author_says_text', __( 'says', 'genesis' ) ) );
				?>
		 	</p>

			<p class="comment-meta">
				<?php
				$pattern = '<time itemprop="commentTime" datetime="%s"><a href="%s" itemprop="url">%s %s %s</a></time>';
				printf( $pattern, esc_attr( get_comment_time( 'c' ) ), esc_url( get_comment_link( $comment->comment_ID ) ), esc_html( get_comment_date() ), __( 'at', 'genesis' ), esc_html( get_comment_time() ) );

				edit_comment_link( __( '(Edit)', 'genesis' ), ' ' );
				?>
			</p>
		</header>

		<div class="comment-content" itemprop="commentText">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="alert"><?php echo apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div>

		<?php
		comment_reply_link( array_merge( $args, array(
			'depth'  => $depth,
			'before' => '<div class="comment-reply">',
			'after'  => '</div>',
		) ) );
		?>

		<?php do_action( 'genesis_after_comment' ); ?>

	</article>
	<?php
	//** No ending </li> tag because of comment threading

}

add_action( 'genesis_comment_form', 'genesis_do_comment_form' );
/**
 * Defines the comment form, hooked to <code>genesis_comment_form()</code>
 *
 * @since 1.0.0
 *
 * @return null Returns early if Genesis disables comments for this page or post
 */
function genesis_do_comment_form() {

	/** Bail if comments are closed for this post type */
	if ( ( is_page() && ! genesis_get_option( 'comments_pages' ) ) || ( is_single() && ! genesis_get_option( 'comments_posts' ) ) )
		return;

	comment_form( array( 'format' => 'html5' ) );

}

add_filter( 'comment_form_defaults', 'genesis_comment_form_args' );
/**
 * Filters the default comment form arguments, used by <code>comment_form()</code>.
 * 
 * Applies only to pre-HTML5 child themes.
 *
 * @since 1.8.0
 *
 * @global string $user_identity Display name of the user
 * @global integer $id Post ID to generate the form for
 *
 * @param array $defaults Comment form defaults
 *
 * @return array Filterable array
 */
function genesis_comment_form_args( array $defaults ) {

	//** Use WordPress default HTML5 comment form if themes supports HTML5
	if ( current_theme_supports( 'genesis-html5' ) )
		return $defaults;

	global $user_identity, $id;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="comment-form-author">' .
	          '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
	          '<label for="author">' . __( 'Name', 'genesis' ) . '</label> ' .
	          ( $req ? '<span class="required">*</span>' : '' ) .
	          '</p>';

	$email = '<p class="comment-form-email">' .
	         '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
	         '<label for="email">' . __( 'Email', 'genesis' ) . '</label> ' .
	         ( $req ? '<span class="required">*</span>' : '' ) .
	         '</p>';

	$url = '<p class="comment-form-url">' .
	       '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
	       '<label for="url">' . __( 'Website', 'genesis' ) . '</label>' .
	       '</p>';

	$comment_field = '<p class="comment-form-comment">' .
	                 '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
	                 '</p>';

	$args = array(
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Speak Your Mind', 'genesis' ),
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
		),
	);

	/** Merge $args with $defaults */
	$args = wp_parse_args( $args, $defaults );

	/** Return filterable array of $args, along with other optional variables */
	return apply_filters( 'genesis_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );

}
