<style>
    .thumbnail {
        min-height: 330px;
    }
</style>
<div class="wrap bootstrap-wpadmin">
  <h2>Sizzle Pack</h2>
  <div class="span3">
      <div class="well sidebar-nav">
          <ul class="nav nav-list">
            <li id="filterByTagsList" class="nav-header">Tags</li>
          </ul>
      </div>
  </div>
  <div class="span9">
    <ul id="module_grid" class="thumbnails"></ul>
  </div>
</div>

<script type="text/template" id="moduleTemplate">
<div class="thumbnail">
    <img src="<?php echo SZZL_PACK_URL; ?><%= thumbnail %>" alt="">
    <h2><%= name %></h2>
    <p><%= description %></p>
    <div class="btn-group" data-toggle="buttons-radio">
        <button data-enabled="true" class="btn btn-primary">Enabled</button>
        <button data-enabled="false" class="btn btn-primary">Disabled</button>
    </div>
</div>
</script>

<script>
jQuery(document).ready(function($) {
  var Module = { Views:{} };
  Module.Model = Backbone.Model.extend({
    defaults : {
        'enabled' : false
    },
    url : ajaxurl+'?action=save_module',
    toJSON : function() {
        var attrs = _.clone( this.attributes );
        //attrs.post_id = wpq.post_id;
        return attrs;
    }
  });
  Module.Collection = Backbone.Collection.extend({
    model: Module.Model,
    byTag: function(tag) {
      console.log('filtering modules by',tag);
      var filteredModuleCollection = this.filter( function(module) {
        return _.contains(module.get("tags"),tag);
      });
      return new Module.Collection(filteredModuleCollection);
    }      
  });
  Module.Views.ModulesGrid = Backbone.View.extend({
    initialize:function () {
        $(this.el).html('');
        this.collection.each( this.addModule, this );
    },
    addModule : function( model, index ) {
        var module = new Module.Views.Module({ model:model });
        this.$el.append( module.render().el );
    }
  });
  Module.Views.FilterByTagsList = Backbone.View.extend({
    tags: [],
    initialize:function () {
        this.collection.each( this.addTag, this );
    },
    addTag:function ( model ) {
      var that = this;
      _.each(model.get('tags'), function extractTag(theTag) {
        if ( ! _.contains(that.tags, theTag) ) {
          var tagView = new Module.Views.FilterByTag({ tag: theTag });
          that.$el.append( tagView.render().el );
          that.tags.push(theTag);
        }
      });
    }
  });
  Module.Views.FilterByTag = Backbone.View.extend({
    tagName:'li',
    events : {
        'click a' : 'navigateToTag'
    },
    navigateToTag : function( e ) {
        e.preventDefault();
        window.Workspace.navigate("tagged/" + this.options.tag, { trigger: true });
    },
    render:function () {
        this.$el.html( '<a href="#">' + this.options.tag + '</a>' );
        return this;
    }
  });
  Module.Views.Module = Backbone.View.extend({
    tagName: 'li',
    className: 'span3',
    template :_.template( $("#moduleTemplate").html() ),    
    initialize:function () {
        var that = this;
        // After the model is saved, return the button to the enabled state
        this.model.on( 'sync', function() {
            that.$('button').attr( 'disabled', false );
        });
    },
    events : {
        'click button' : 'save'
    },
    save : function( e ) {
        e.preventDefault();
        this.$('button').attr( 'disabled', true );

        // wait until bootstrap buttons have set their state - https://github.com/twitter/bootstrap/blob/master/js/bootstrap-button.js#L45
        var that = this;
        setTimeout(function () {
          that.model.set( 'enabled', that.$el.find('.btn.active').first().data('enabled') );    
          that.model.save();
        }, 1);
    },
    render:function () {
        this.model.set( 'index', this.model.collection.indexOf( this.model ) + 1 );
        this.$el.html( this.template( this.model.toJSON() ) );
        this.update_checkbox_button_state(this.$el, this.model.get('enabled'));
        this.$el.button();
        return this;
    },
    update_checkbox_button_state: function(el, enabled) {
      el.find("[data-enabled='true']").each(function() { enabled ? $(this).addClass('active') : $(this).removeClass('active'); });
      el.find("[data-enabled='false']").each(function() { ! enabled ? $(this).addClass('active') : $(this).removeClass('active'); });
    }
  });
  var Workspace = Backbone.Router.extend({
    routes: {
      "":            "index",
      "tagged/:tag": "filterByTag"
    },
    initialize: function() {
      window.moduleCollection = new Module.Collection( modules );
    },
    index: function() {
      var moduleGrid = new Module.Views.ModulesGrid({ collection:window.moduleCollection.byTag("popular"), el:'#module_grid' });
      var tagsList = new Module.Views.FilterByTagsList({ collection:window.moduleCollection, el:'#filterByTagsList' });
    },
    filterByTag: function(tag) {
      var moduleGrid = new Module.Views.ModulesGrid({ collection:window.moduleCollection.byTag(tag), el:'#module_grid' });
      var tagsList = new Module.Views.FilterByTagsList({ collection:window.moduleCollection, el:'#filterByTagsList' });
    }
  });
  
  var modules = <?php echo json_encode( array_values( $this->modules ) ); ?>;
  window.Workspace = new Workspace();
  Backbone.history.start();
  
});
</script>