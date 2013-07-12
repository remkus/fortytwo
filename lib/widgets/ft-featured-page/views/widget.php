<!-- This file is used to markup the public-facing widget. -->
<div class="post-x page type-page status-publish hentry entry">
  <?php echo $before_title ?><i class="<?php echo esc_html( $instance['icon'] ) ?>"></i> <?php echo esc_html( $instance['title'] ) ?><?php echo $after_title ?>
  <p><?php echo esc_html( $instance['content'] ); ?></p>
  <a class="btn" href="<?php echo esc_url( $instance['button_link'] ) ?>"><?php echo esc_html( $instance['button_text'] ) ?></a>
</div>
