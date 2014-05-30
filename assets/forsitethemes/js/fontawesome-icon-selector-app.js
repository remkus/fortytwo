/**!
 * FortyTwo Theme {@link http://forsitethemes/themes/fortytwo/}
 *
 * @author  Forsite Themes
 * @license GPL-2.0+
 */

/* global _, Backbone */
(function( $ ) {
	'use strict';
	var AdminApp = { Views: {} };
	AdminApp.Icon = Backbone.Model.extend({
		defaults: {
			name: null,
			css: null
		}
	});

	AdminApp.IconCollection = Backbone.Collection.extend({
		model: AdminApp.Icon,

		iconSelected: null,

		initialize: function( models, options ) {
			if (_.isUndefined( models ) ) {
				this.reset( AdminApp.getFontAwesomeIcons(), _.extend( { silent: true }, options ) );
			}
		},

		getSelected: function() {
			if ( _.isNull( this.iconSelected ) ) {
				this.iconSelected = this.models[0];
			}
			return this.iconSelected;
		},

		setSelected: function( iconModel ) {
			this.iconSelected = iconModel;
			this.trigger( 'change:selectedIcon', this.iconSelected );
		},

		setSelectedByCss: function( iconCss ) {
			this.setSelected( this.find( function( icon ) {
				return icon.get( 'css' ) === iconCss;
			})
			);
		},

		byName: function( name ) {
			var filteredIconCollection, pattern = new RegExp( name, 'gi' );
			filteredIconCollection = this.filter( function( icon ) {
				return pattern.test( icon.get( 'name' ) );
			});
			return new AdminApp.IconCollection( filteredIconCollection );
		}
	});

	AdminApp.Views.IconListView = Backbone.View.extend({
		template: _.template(
'<div class="the-icon-selector-wrapper">' +
	'<i class="the-selected-icon"></i>' +
	'<div class="the-icon-selector-dropdown">' +
		'<input id="the-icon-filter" placeholder="Filter icons by name" />' +
		'<div class="the-icon-list"></div>' +
	'</div>' +
'</div>' ),

		iconDialog: {},

		initialize: function( options ) {
			this.options = options || {};
			this.$el.html( this.template() );
			//Note that this removes the element and replaces it with JQuery UI elements,
			//that we store a reference to in this.iconDialog
			this.iconDialog = this.$el.find( '.the-icon-selector-dropdown' ).dialog({
				modal: true,
				autoOpen: false,
				dialogClass: 'the-icon-selector-dialog',
				title: '',
				height: 300,
				position: { my: 'right-15', at: 'bottom', of: this.$el },
				show: { effect: 'slide', direction: 'right' }
			});
			this.iconDialog.find( 'INPUT' ).keyup( this, this.filterIconList );

			this.collection.on( 'change:selectedIcon', this.updateSelectedIcon, this );
			this.collection.setSelectedByCss( this.options.selectedIconCss );
			this.renderIconList( this.collection );
		},

		events: {
			'click .the-selected-icon': 'showDropDown'
		},

		updateSelectedIcon: function( selectedIcon ) {
			var elIcon = this.$el.find( '.the-selected-icon' );
			elIcon.removeClass();
			if ( selectedIcon ) {
				elIcon.addClass( 'the-selected-icon ft-ico ft-ico-2x ' + selectedIcon.get( 'css' ) );
			}
			this.hideDropDown();
		},

		renderIconList: function( icons ) {
			this.iconDialog.find( '.the-icon-list' ).empty();
			icons.each( this.addIcon, this );
		},

		addIcon: function( model ) {
			var iconView = new AdminApp.Views.IconView({ model: model });
			this.iconDialog.find( '.the-icon-list' ).append( iconView.render().el );
		},

		filterIconList: function( e ) {
			var searchQuery, view = e.data;
			searchQuery = e.currentTarget.value;
			if ( searchQuery.length > 2 ) {
				view.renderIconList( view.collection.byName( searchQuery ) );
			} else {
				view.renderIconList( view.collection );
			}
		},

		showDropDown: function() {
			this.iconDialog.dialog( 'open' );
		},

		hideDropDown: function() {
			this.iconDialog.dialog( 'close' );
		}
	});

	AdminApp.Views.IconView = Backbone.View.extend({
		tagName: 'span',

		template: _.template( '<i class="ft-ico <%= css %> ft-ico-2x" title="<%= name %>">&nbsp;</i>' ),

		events: {
			click: 'selectIcon'
		},

		selectIcon: function( e ) {
			e.preventDefault();
			this.model.collection.setSelected( this.model );
		},

		render: function() {
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		}
	});

	AdminApp.currentApps = [];

	//Attach the app to a set of Widget Elements
	AdminApp.attachApp = function( currentSelectedIcon, iconSelectorElement, iconSaveInputElement ) {
		//Do nothing if app has already been bound to this element
		if ( $( iconSelectorElement ).data( 'FontAwesomeIconSelectorApp' ) ) {
			return;
		}

		var iconCollection = new AdminApp.IconCollection();
		iconCollection.on( 'change:selectedIcon', function( selectedIcon ) {
			if ( selectedIcon ) {
				$( iconSaveInputElement ).val( selectedIcon.get( 'css' ) );
			}
		});

		new AdminApp.Views.IconListView({
			collection: iconCollection,
			selectedIconCss: currentSelectedIcon || 'ft-ico-arrow-circle-right',
			el: iconSelectorElement
		});

		//Record that we have attached an app to this element
		$( iconSelectorElement ).data( 'FontAwesomeIconSelectorApp', true );
	};

	AdminApp.getFontAwesomeIcons = function() {
		// The placeholder is replaced with the full list via the grunt replace:fonticons task
		var iconModels, iconClasses = [
			'@@fonticonclasses'
		];

		// Convert from an array of strings to an array of backbone iconModels
		iconModels = _.map(iconClasses, function( iconClass ) {
			return { name: iconClass.replace( 'ft-ico-', '' ), css: iconClass };
		});

		return iconModels;
	};

	window.FontAwesomeIconSelectorApp = AdminApp;

	// Ensure that after a new widget is saved,
	// that the FontAwesomeIconSelectorApp is attached to the new element
	$( document ).on( 'saved_widget', function( event, widget ) {
		var widgetId = $( widget ).find( 'input.widget-id' ).val(),
			iconSaveInputElement = '#widget-' + widgetId + '-icon',
			iconSelectorElement = '.widget-' + widgetId + '-the-icon-selector',
			selectedIcon = $( iconSaveInputElement ).val();
		if ( widgetId && widgetId.indexOf( 'featured-content' ) > -1 ) {
			window.FontAwesomeIconSelectorApp.attachApp( selectedIcon, iconSelectorElement, iconSaveInputElement );
		}
	});
})( jQuery );
