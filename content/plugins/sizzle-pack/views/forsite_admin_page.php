<?php
  $modules = array();
  $modules["widgets"][] = array("id"=> "FST_Slideshow_Widget", "name" => "FST Slideshow Widget", 
                                "thumbnail" => FST_PACK_URL . 'modules/slideshow-widget/images/thumbnail.gif',
                                "description" => "A slideshow widget based on ImpressJs, and your widget backend of choice",
                                "tags" => "popular");
  $modules["widgets"][] = array("id"=> "FST_Tabs_Widget", "name" => "FST Tabs Widget", 
                                "thumbnail" => FST_PACK_URL . 'modules/fst-tabs-widget/images/thumbnail.gif',
                                "description" => "Allows grouping of other widgets into tabs",
                                "tags" => "popular");
  $modules["widgets"][] = array("id"=> "FST_Contact_Widget", "name" => "FST Contact Widget", 
                                "thumbnail" => FST_PACK_URL . 'modules/fst-contact-widget/images/thumbnail.gif',
                                "description" => "a Schema.org compliant contact widget",
                                "tags" => "");
  $modules["plugins"][] = array("id"=> "FST_Menu_Extensions", "name" => "FST Menu Extensions", 
                                "thumbnail" => "http://placehold.it/260x180",
                                "description" => "Add custom menu types including Nav header, Nav Divider and Nav Widget Area",
                                "tags" => "popular");
?>
<style>
    .thumbnail {
        min-height: 330px;
    }
</style>
<div class="wrap bootstrap-wpadmin">
<h2>Forsite Extension Pack</h2>
<form method="post" action="options.php">
<?php 
    settings_errors();
    settings_fields( 'fst' ); 
?>
<div class="span3">
    <div class="well sidebar-nav">
        <ul class="nav nav-list">
        <li class="nav-header">Categories</li>
            <li><a id="show-popular">Popular</a></li>
            <li><a id="show-widgets">Widgets</a></li>
            <li><a id="show-plugins">Plugins</a></li>
        </ul>
    </div>
</div>
<div class="span9">
<?php 
  function echo_module_box($module) { ?>
    <li data-id="<?php echo $module["id"]?>" class="span3">
        <div class="thumbnail">
        <img src="<?php echo $module["thumbnail"]?>" alt="">
        <h2><?php echo $module["name"]?></h2>
        <p><?php echo $module["description"]?></p>
        <div class="btn-group" data-toggle="buttons-radio">
            <button data-module-id="<?php echo $module["id"]?>" data-state="1" class="btn">Enabled</button>
            <button data-module-id="<?php echo $module["id"]?>" data-state="0" class="btn">Disabled</button>
        </div>
    </div>
    </li>
  <?php
  }
?>
<ul id="fst_popular_grid" class="thumbnails">
  <?php foreach ($modules as $module_type => $module_types) {
          foreach ($module_types as $module) { ?>  
            <input id="<?php echo $module["id"]?>"
                   name="fst_modules_enabled[<?php echo $module_type ?>][<?php echo $module["id"] ?>][enabled]" 
                   type="hidden" value="<?php echo $this->data[$module_type][$module["id"]]['enabled'] ?>" />
    <?php if (stristr($module["tags"],"popular")) {
            echo_module_box($module, $module_type);
          }
      }
  }
  ?>
</ul>
<ul id="fst_widget_grid" class="hidden thumbnails">
  <?php foreach ($modules['widgets'] as $module) {
            echo_module_box($module, 'widgets');
        } ?>
</ul>
<ul id="fst_plugin_grid" class="hidden thumbnails">
  <?php foreach ($modules['plugins'] as $module) {
            echo_module_box($module, 'plugins');
        } ?>
</ul>
<p><input type="submit" class="btn btn-large btn-primary" value="Save changes" /></p>
</div>
</form>
</div>
<script>
jQuery(document).ready(function($) {
    
    $("#show-popular").click(function(e) {
       $('#fst_popular_grid').quicksand( $('#fst_popular_grid li'), function() {
           attach_button_click_handlers(); //need to reattach handlers after animation
       });
       e.preventDefault();
    });
    
    $("#show-widgets").click(function(e) {
       $('#fst_popular_grid').quicksand( $('#fst_widget_grid li'), function() {
           attach_button_click_handlers(); //need to reattach handlers after animation
       });
       e.preventDefault();
    });
    
    $("#show-plugins").click(function(e) {
       $('#fst_popular_grid').quicksand( $('#fst_plugin_grid li'), function() {
           attach_button_click_handlers(); //need to reattach handlers after animation
       });
       e.preventDefault();
    });
    
    function update_state() {
        $('.btn-group .btn').each(function(idx, btn) {
           if ($("#"+$(btn).data("module-id")).val() == $(btn).data("state")) {
               $(btn).addClass('active');
           } else {
               $(btn).removeClass('active');
           }
        });
    }
    function update_data(e) {
        $("#"+$(this).data("module-id")).val($(this).data("state"));
        update_state();
        e.preventDefault();
    }
    function attach_button_click_handlers() {
        $('.btn-group .btn').unbind('click', update_data).bind('click', update_data);
    }
    update_state();
    attach_button_click_handlers();
});
</script>
