<?php
/**
 * Represents the view for the featured content that gets output to site.
 */
?>

<?php echo $before_title ?>
	<i class="ft-ico <?php echo esc_html( $instance['icon'] ) ?>"></i> <?php echo esc_html( $instance['title'] ) ?>
<?php echo $after_title ?>

<p><?php echo esc_html( $instance['content'] ); ?></p>

<a class="btn" href="<?php echo esc_url( $instance['button_link'] ) ?>"><?php echo esc_html( $instance['button_text'] ) ?></a>

