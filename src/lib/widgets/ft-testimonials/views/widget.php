<?php
/**
 * FortyTwo Theme: Testimonials Widget Widget
 *
 * Represents the widget for the Tabs Widget in the backend.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<h4 class="widgettitle"><?php echo $instance['title']; ?></h4>
<div class="testimonial-content">
	<?php foreach ( $instance['testimonials'] as $testimonial ) { ?>
		<blockquote>
			<p><?php echo $testimonial['content']; ?></p>
			<small><?php echo $testimonial['quote_source_formatted']; ?></small>
		</blockquote>
		<?php if ( $testimonial !== end( $instance['testimonials'] ) ) { ?>
			<hr/><?php } ?>
	<?php } ?>
</div>
