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
?>
<div class="ft-jumbotron-detail">
	<span><?php echo esc_html( $instance['title'] ) ?></span>
	<p><?php echo esc_html( $instance['content'] ) ?></p>
</div>
<a class="btn ft-jumbotron-action" href="<?php echo esc_url( $instance['button_link'] ); ?>"><?php echo esc_html( $instance['button_text'] ); ?></a>
