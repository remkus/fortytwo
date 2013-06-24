<!-- This file is used to markup the public-facing widget. -->
<div class="post-x page type-page status-publish hentry entry">
  <?php echo $before_title ?><i class="icon-beaker"></i> <?php echo esc_html($title) ?><?php echo $after_title ?>
  <p><?php echo esc_html($content); ?></p>
  <a class="btn" href="<?php echo esc_url($button_link) ?>"><?php echo esc_html($button_text) ?></a>
</div>