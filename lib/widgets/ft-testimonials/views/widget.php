<h4 class="widgettitle"><?php echo $instance['title']; ?></h4>
<div class="testimonial-content">
  <?php foreach($instance['testimonials'] as $testimonial) { ?>
  <figure>
	  <blockquote>
	    <p><?php echo $testimonial['content'];?></p>
	    <figcaption>
	    	<small>Someone famous <cite title="<?php echo $testimonial['title'];?>"><?php echo $testimonial['title'];?></cite></small>
	    </figquote>
	  </blockquote>
  </figure>
  <?php if ($testimonial !== end($instance['testimonials'])) { ?><hr /><?php } ?>
  <?php } ?>
</div>
