<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

echo $args['before_title']; ?>
<i class="ft-ico <?php echo sanitize_html_class( $instance['icon'] ); ?>"></i> <?php echo esc_html( $instance['title'] ); ?>
<?php echo $args['after_title']; ?>
<?php if ( $instance['content'] ) { ?>
<p><?php echo esc_html( $instance['content'] ); ?></p>
<?php }
if ( $instance['link_url'] && $instance['link_text'] ) { ?>
<a class="btn" href="<?php echo esc_url( $instance['link_url'] ); ?>"><?php echo esc_html( $instance['link_text'] ); ?></a>
<?php }