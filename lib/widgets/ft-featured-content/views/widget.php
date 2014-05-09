<?php
/**
 * FortyTwo Theme: Featured Content Widget
 *
 * Represents the widget for the featured content that gets output to site.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<?php echo $args['before_title']; ?>
	<i class="ft-ico <?php echo sanitize_html_class( $instance['icon'] ) ?>"></i> <?php echo esc_html( $instance['title'] ) ?>
<?php echo $args['after_title']; ?>

<p><?php echo esc_html( $instance['content'] ); ?></p>

<a class="btn" href="<?php echo esc_url( $instance['button_link'] ) ?>"><?php echo esc_html( $instance['button_text'] ) ?></a>
