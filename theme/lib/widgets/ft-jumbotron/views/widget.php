<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

if ( $instance['title'] || $instance['content'] ) {
?>
<div class="ft-jumbotron-detail">
	<span><?php echo esc_html( $instance['title'] ); ?></span>
	<p><?php echo esc_html( $instance['content'] ); ?></p>
</div>
<?php }
if ( $instance['link_url'] && $instance['link_text'] ) { ?>
<a class="btn ft-jumbotron-action" href="<?php echo esc_url( $instance['link_url'] ); ?>"><?php echo esc_html( $instance['link_text'] ); ?></a>
<?php }
