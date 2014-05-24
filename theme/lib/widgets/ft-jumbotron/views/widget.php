<?php
/**
 * FortyTwo Theme: Jumbotron Widget View
 *
 * Represents the view for the Jumbotron widget form in the backend.
 *
 * @package FortyTwo\Widgets
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
