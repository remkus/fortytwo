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

/**
 *
 * @todo  This code needs better documentation
 * @var [type]
 */
$action_button_text = esc_html( $instance['button_text'] );
$action_button_link = esc_url( $instance['button_link'] );
$action_button_align = strtolower( $instance['button_alignment'] );

$action_button = <<<HTML
<a class="btn ft-jumbotron-action pull-$action_button_align" href="$action_button_link">$action_button_text</a>
HTML;
?>

<?php echo $action_button; ?>
<div class="ft-jumbotron-detail">
	<span><?php echo esc_html( $instance['title'] ) ?></span>
	<p><?php echo esc_html( $instance['content'] ) ?></p>
</div>
