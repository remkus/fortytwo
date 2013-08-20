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