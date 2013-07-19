<?php
$action_button_text = esc_html( $instance['button_text'] );
$action_button_link = esc_url( $instance['button_link'] );
$action_button = <<<HTML
<div class="ft-jumbotron-action">
		<a class="btn btn-primary" href="$action_button_link">$action_button_text</a>
</div>
HTML;
?>
<div class="row">
		<?php if ( strtolower( $instance['button_alignment'] ) == 'left' ) { echo $action_button; } ?>
    <div class="ft-jumbotron-detail">
        <span><?php echo esc_html( $instance['title'] ) ?></span>
        <p><?php echo esc_html( $instance['content'] ) ?></p>
    </div>
    <?php if ( strtolower( $instance['button_alignment'] ) == 'right' ) { echo $action_button; } ?>
</div>
