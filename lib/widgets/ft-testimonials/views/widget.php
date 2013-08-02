<h4 class="widgettitle"><?php echo $instance['title']; ?></h4>
<div class="testimonial-content">
  <?php foreach($instance['testimonials'] as $testimonial) { ?>
  <blockquote>
    <p><?php echo $testimonial['content'];?></p>
    <small><?php if ($testimonial['quote_author']) { echo $testimonial['quote_author'].' '.__('in', 'fortytwo').' '; }?>
    	<a href="<?php echo $testimonial['quote_source_link'];?>">
    		<cite title="<?php echo $testimonial['quote_source'];?>">
    			<?php echo $testimonial['quote_source'];?>
    		</cite>
    	</a>
    </small>
  </blockquote>
  <?php if ($testimonial !== end($instance['testimonials'])) { ?><hr /><?php } ?>
  <?php } ?>
</div>
