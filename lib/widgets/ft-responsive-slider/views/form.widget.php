<div id="<?php echo $this->get_field_id( 'container' )?>" class="ft-responsive-slider-container">
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</label>
	</p>
	<div class="dialog">
    <iframe class="content-iframe" src="<?php echo ft_responsive_slider_url('/views/loading.php');?>"></iframe>
	</div>
	<a href="#" class="openDialogButton"><?php _e('Advanced settings', 'fortytwo' )?></a>
</div>

<script>
(function ($) {
	"use strict";
	$(document).ready(function () {
		var dialogContainer = $('#<?php echo $this->get_field_id( 'container' )?>'),
				theDialog = dialogContainer.find('.dialog');
		
		theDialog.dialog({
			modal: true,
  		autoOpen: false,
  		dialogClass: "ft-responsive-slider-container-dialog",
  		title: "",
  		height: 600,
  		width: 700,
  		position: { my: "right-100", at: "bottom", of: dialogContainer },
  		show: { effect: "slide", direction: "right" },
	    open: function(ev, ui){
         theDialog.find('.content-iframe').attr('src','/wp-admin/admin.php?page=ft_responsive_slider');
      }
		});

		dialogContainer.find('.openDialogButton').click(function(){
		  theDialog.dialog('open');
		});
	});
}(jQuery));
</script>


