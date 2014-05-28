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

	// The placeholder is replaced with the full list via the grunt replace:fonticons task
	AdminApp.getFontAwesomeIcons = function() {
		var iconModels, iconClasses = [
			'ft-ico-glass',
			'ft-ico-music',
			'ft-ico-search',
			'ft-ico-envelope-o',
			'ft-ico-heart',
			'ft-ico-star',
			'ft-ico-star-o',
			'ft-ico-user',
			'ft-ico-film',
			'ft-ico-th-large',
			'ft-ico-th',
			'ft-ico-th-list',
			'ft-ico-check',
			'ft-ico-times',
			'ft-ico-search-plus',
			'ft-ico-search-minus',
			'ft-ico-power-off',
			'ft-ico-signal',
			'ft-ico-gear',
			'ft-ico-cog',
			'ft-ico-trash-o',
			'ft-ico-home',
			'ft-ico-file-o',
			'ft-ico-clock-o',
			'ft-ico-road',
			'ft-ico-download',
			'ft-ico-arrow-circle-o-down',
			'ft-ico-arrow-circle-o-up',
			'ft-ico-inbox',
			'ft-ico-play-circle-o',
			'ft-ico-rotate-right',
			'ft-ico-repeat',
			'ft-ico-refresh',
			'ft-ico-list-alt',
			'ft-ico-lock',
			'ft-ico-flag',
			'ft-ico-headphones',
			'ft-ico-volume-off',
			'ft-ico-volume-down',
			'ft-ico-volume-up',
			'ft-ico-qrcode',
			'ft-ico-barcode',
			'ft-ico-tag',
			'ft-ico-tags',
			'ft-ico-book',
			'ft-ico-bookmark',
			'ft-ico-print',
			'ft-ico-camera',
			'ft-ico-font',
			'ft-ico-bold',
			'ft-ico-italic',
			'ft-ico-text-height',
			'ft-ico-text-width',
			'ft-ico-align-left',
			'ft-ico-align-center',
			'ft-ico-align-right',
			'ft-ico-align-justify',
			'ft-ico-list',
			'ft-ico-dedent',
			'ft-ico-outdent',
			'ft-ico-indent',
			'ft-ico-video-camera',
			'ft-ico-photo',
			'ft-ico-image',
			'ft-ico-picture-o',
			'ft-ico-pencil',
			'ft-ico-map-marker',
			'ft-ico-adjust',
			'ft-ico-tint',
			'ft-ico-edit',
			'ft-ico-pencil-square-o',
			'ft-ico-share-square-o',
			'ft-ico-check-square-o',
			'ft-ico-arrows',
			'ft-ico-step-backward',
			'ft-ico-fast-backward',
			'ft-ico-backward',
			'ft-ico-play',
			'ft-ico-pause',
			'ft-ico-stop',
			'ft-ico-forward',
			'ft-ico-fast-forward',
			'ft-ico-step-forward',
			'ft-ico-eject',
			'ft-ico-chevron-left',
			'ft-ico-chevron-right',
			'ft-ico-plus-circle',
			'ft-ico-minus-circle',
			'ft-ico-times-circle',
			'ft-ico-check-circle',
			'ft-ico-question-circle',
			'ft-ico-info-circle',
			'ft-ico-crosshairs',
			'ft-ico-times-circle-o',
			'ft-ico-check-circle-o',
			'ft-ico-ban',
			'ft-ico-arrow-left',
			'ft-ico-arrow-right',
			'ft-ico-arrow-up',
			'ft-ico-arrow-down',
			'ft-ico-mail-forward',
			'ft-ico-share',
			'ft-ico-expand',
			'ft-ico-compress',
			'ft-ico-plus',
			'ft-ico-minus',
			'ft-ico-asterisk',
			'ft-ico-exclamation-circle',
			'ft-ico-gift',
			'ft-ico-leaf',
			'ft-ico-fire',
			'ft-ico-eye',
			'ft-ico-eye-slash',
			'ft-ico-warning',
			'ft-ico-exclamation-triangle',
			'ft-ico-plane',
			'ft-ico-calendar',
			'ft-ico-random',
			'ft-ico-comment',
			'ft-ico-magnet',
			'ft-ico-chevron-up',
			'ft-ico-chevron-down',
			'ft-ico-retweet',
			'ft-ico-shopping-cart',
			'ft-ico-folder',
			'ft-ico-folder-open',
			'ft-ico-arrows-v',
			'ft-ico-arrows-h',
			'ft-ico-bar-chart-o',
			'ft-ico-twitter-square',
			'ft-ico-facebook-square',
			'ft-ico-camera-retro',
			'ft-ico-key',
			'ft-ico-gears',
			'ft-ico-cogs',
			'ft-ico-comments',
			'ft-ico-thumbs-o-up',
			'ft-ico-thumbs-o-down',
			'ft-ico-star-half',
			'ft-ico-heart-o',
			'ft-ico-sign-out',
			'ft-ico-linkedin-square',
			'ft-ico-thumb-tack',
			'ft-ico-external-link',
			'ft-ico-sign-in',
			'ft-ico-trophy',
			'ft-ico-github-square',
			'ft-ico-upload',
			'ft-ico-lemon-o',
			'ft-ico-phone',
			'ft-ico-square-o',
			'ft-ico-bookmark-o',
			'ft-ico-phone-square',
			'ft-ico-twitter',
			'ft-ico-facebook',
			'ft-ico-github',
			'ft-ico-unlock',
			'ft-ico-credit-card',
			'ft-ico-rss',
			'ft-ico-hdd-o',
			'ft-ico-bullhorn',
			'ft-ico-bell',
			'ft-ico-certificate',
			'ft-ico-hand-o-right',
			'ft-ico-hand-o-left',
			'ft-ico-hand-o-up',
			'ft-ico-hand-o-down',
			'ft-ico-arrow-circle-left',
			'ft-ico-arrow-circle-right',
			'ft-ico-arrow-circle-up',
			'ft-ico-arrow-circle-down',
			'ft-ico-globe',
			'ft-ico-wrench',
			'ft-ico-tasks',
			'ft-ico-filter',
			'ft-ico-briefcase',
			'ft-ico-arrows-alt',
			'ft-ico-group',
			'ft-ico-users',
			'ft-ico-chain',
			'ft-ico-link',
			'ft-ico-cloud',
			'ft-ico-flask',
			'ft-ico-cut',
			'ft-ico-scissors',
			'ft-ico-copy',
			'ft-ico-files-o',
			'ft-ico-paperclip',
			'ft-ico-save',
			'ft-ico-floppy-o',
			'ft-ico-square',
			'ft-ico-navicon',
			'ft-ico-reorder',
			'ft-ico-bars',
			'ft-ico-list-ul',
			'ft-ico-list-ol',
			'ft-ico-strikethrough',
			'ft-ico-underline',
			'ft-ico-table',
			'ft-ico-magic',
			'ft-ico-truck',
			'ft-ico-pinterest',
			'ft-ico-pinterest-square',
			'ft-ico-google-plus-square',
			'ft-ico-google-plus',
			'ft-ico-money',
			'ft-ico-caret-down',
			'ft-ico-caret-up',
			'ft-ico-caret-left',
			'ft-ico-caret-right',
			'ft-ico-columns',
			'ft-ico-unsorted',
			'ft-ico-sort',
			'ft-ico-sort-down',
			'ft-ico-sort-desc',
			'ft-ico-sort-up',
			'ft-ico-sort-asc',
			'ft-ico-envelope',
			'ft-ico-linkedin',
			'ft-ico-rotate-left',
			'ft-ico-undo',
			'ft-ico-legal',
			'ft-ico-gavel',
			'ft-ico-dashboard',
			'ft-ico-tachometer',
			'ft-ico-comment-o',
			'ft-ico-comments-o',
			'ft-ico-flash',
			'ft-ico-bolt',
			'ft-ico-sitemap',
			'ft-ico-umbrella',
			'ft-ico-paste',
			'ft-ico-clipboard',
			'ft-ico-lightbulb-o',
			'ft-ico-exchange',
			'ft-ico-cloud-download',
			'ft-ico-cloud-upload',
			'ft-ico-user-md',
			'ft-ico-stethoscope',
			'ft-ico-suitcase',
			'ft-ico-bell-o',
			'ft-ico-coffee',
			'ft-ico-cutlery',
			'ft-ico-file-text-o',
			'ft-ico-building-o',
			'ft-ico-hospital-o',
			'ft-ico-ambulance',
			'ft-ico-medkit',
			'ft-ico-fighter-jet',
			'ft-ico-beer',
			'ft-ico-h-square',
			'ft-ico-plus-square',
			'ft-ico-angle-double-left',
			'ft-ico-angle-double-right',
			'ft-ico-angle-double-up',
			'ft-ico-angle-double-down',
			'ft-ico-angle-left',
			'ft-ico-angle-right',
			'ft-ico-angle-up',
			'ft-ico-angle-down',
			'ft-ico-desktop',
			'ft-ico-laptop',
			'ft-ico-tablet',
			'ft-ico-mobile-phone',
			'ft-ico-mobile',
			'ft-ico-circle-o',
			'ft-ico-quote-left',
			'ft-ico-quote-right',
			'ft-ico-spinner',
			'ft-ico-circle',
			'ft-ico-mail-reply',
			'ft-ico-reply',
			'ft-ico-github-alt',
			'ft-ico-folder-o',
			'ft-ico-folder-open-o',
			'ft-ico-smile-o',
			'ft-ico-frown-o',
			'ft-ico-meh-o',
			'ft-ico-gamepad',
			'ft-ico-keyboard-o',
			'ft-ico-flag-o',
			'ft-ico-flag-checkered',
			'ft-ico-terminal',
			'ft-ico-code',
			'ft-ico-mail-reply-all',
			'ft-ico-reply-all',
			'ft-ico-star-half-empty',
			'ft-ico-star-half-full',
			'ft-ico-star-half-o',
			'ft-ico-location-arrow',
			'ft-ico-crop',
			'ft-ico-code-fork',
			'ft-ico-unlink',
			'ft-ico-chain-broken',
			'ft-ico-question',
			'ft-ico-info',
			'ft-ico-exclamation',
			'ft-ico-superscript',
			'ft-ico-subscript',
			'ft-ico-eraser',
			'ft-ico-puzzle-piece',
			'ft-ico-microphone',
			'ft-ico-microphone-slash',
			'ft-ico-shield',
			'ft-ico-calendar-o',
			'ft-ico-fire-extinguisher',
			'ft-ico-rocket',
			'ft-ico-maxcdn',
			'ft-ico-chevron-circle-left',
			'ft-ico-chevron-circle-right',
			'ft-ico-chevron-circle-up',
			'ft-ico-chevron-circle-down',
			'ft-ico-html5',
			'ft-ico-css3',
			'ft-ico-anchor',
			'ft-ico-unlock-alt',
			'ft-ico-bullseye',
			'ft-ico-ellipsis-h',
			'ft-ico-ellipsis-v',
			'ft-ico-rss-square',
			'ft-ico-play-circle',
			'ft-ico-ticket',
			'ft-ico-minus-square',
			'ft-ico-minus-square-o',
			'ft-ico-level-up',
			'ft-ico-level-down',
			'ft-ico-check-square',
			'ft-ico-pencil-square',
			'ft-ico-external-link-square',
			'ft-ico-share-square',
			'ft-ico-compass',
			'ft-ico-toggle-down',
			'ft-ico-caret-square-o-down',
			'ft-ico-toggle-up',
			'ft-ico-caret-square-o-up',
			'ft-ico-toggle-right',
			'ft-ico-caret-square-o-right',
			'ft-ico-euro',
			'ft-ico-eur',
			'ft-ico-gbp',
			'ft-ico-dollar',
			'ft-ico-usd',
			'ft-ico-rupee',
			'ft-ico-inr',
			'ft-ico-cny',
			'ft-ico-rmb',
			'ft-ico-yen',
			'ft-ico-jpy',
			'ft-ico-ruble',
			'ft-ico-rouble',
			'ft-ico-rub',
			'ft-ico-won',
			'ft-ico-krw',
			'ft-ico-bitcoin',
			'ft-ico-btc',
			'ft-ico-file',
			'ft-ico-file-text',
			'ft-ico-sort-alpha-asc',
			'ft-ico-sort-alpha-desc',
			'ft-ico-sort-amount-asc',
			'ft-ico-sort-amount-desc',
			'ft-ico-sort-numeric-asc',
			'ft-ico-sort-numeric-desc',
			'ft-ico-thumbs-up',
			'ft-ico-thumbs-down',
			'ft-ico-youtube-square',
			'ft-ico-youtube',
			'ft-ico-xing',
			'ft-ico-xing-square',
			'ft-ico-youtube-play',
			'ft-ico-dropbox',
			'ft-ico-stack-overflow',
			'ft-ico-instagram',
			'ft-ico-flickr',
			'ft-ico-adn',
			'ft-ico-bitbucket',
			'ft-ico-bitbucket-square',
			'ft-ico-tumblr',
			'ft-ico-tumblr-square',
			'ft-ico-long-arrow-down',
			'ft-ico-long-arrow-up',
			'ft-ico-long-arrow-left',
			'ft-ico-long-arrow-right',
			'ft-ico-apple',
			'ft-ico-windows',
			'ft-ico-android',
			'ft-ico-linux',
			'ft-ico-dribbble',
			'ft-ico-skype',
			'ft-ico-foursquare',
			'ft-ico-trello',
			'ft-ico-female',
			'ft-ico-male',
			'ft-ico-gittip',
			'ft-ico-sun-o',
			'ft-ico-moon-o',
			'ft-ico-archive',
			'ft-ico-bug',
			'ft-ico-vk',
			'ft-ico-weibo',
			'ft-ico-renren',
			'ft-ico-pagelines',
			'ft-ico-stack-exchange',
			'ft-ico-arrow-circle-o-right',
			'ft-ico-arrow-circle-o-left',
			'ft-ico-toggle-left',
			'ft-ico-caret-square-o-left',
			'ft-ico-dot-circle-o',
			'ft-ico-wheelchair',
			'ft-ico-vimeo-square',
			'ft-ico-turkish-lira',
			'ft-ico-try',
			'ft-ico-plus-square-o',
			'ft-ico-space-shuttle',
			'ft-ico-slack',
			'ft-ico-envelope-square',
			'ft-ico-wordpress',
			'ft-ico-openid',
			'ft-ico-institution',
			'ft-ico-bank',
			'ft-ico-university',
			'ft-ico-mortar-board',
			'ft-ico-graduation-cap',
			'ft-ico-yahoo',
			'ft-ico-google',
			'ft-ico-reddit',
			'ft-ico-reddit-square',
			'ft-ico-stumbleupon-circle',
			'ft-ico-stumbleupon',
			'ft-ico-delicious',
			'ft-ico-digg',
			'ft-ico-pied-piper-square',
			'ft-ico-pied-piper',
			'ft-ico-pied-piper-alt',
			'ft-ico-drupal',
			'ft-ico-joomla',
			'ft-ico-language',
			'ft-ico-fax',
			'ft-ico-building',
			'ft-ico-child',
			'ft-ico-paw',
			'ft-ico-spoon',
			'ft-ico-cube',
			'ft-ico-cubes',
			'ft-ico-behance',
			'ft-ico-behance-square',
			'ft-ico-steam',
			'ft-ico-steam-square',
			'ft-ico-recycle',
			'ft-ico-automobile',
			'ft-ico-car',
			'ft-ico-cab',
			'ft-ico-taxi',
			'ft-ico-tree',
			'ft-ico-spotify',
			'ft-ico-deviantart',
			'ft-ico-soundcloud',
			'ft-ico-database',
			'ft-ico-file-pdf-o',
			'ft-ico-file-word-o',
			'ft-ico-file-excel-o',
			'ft-ico-file-powerpoint-o',
			'ft-ico-file-photo-o',
			'ft-ico-file-picture-o',
			'ft-ico-file-image-o',
			'ft-ico-file-zip-o',
			'ft-ico-file-archive-o',
			'ft-ico-file-sound-o',
			'ft-ico-file-audio-o',
			'ft-ico-file-movie-o',
			'ft-ico-file-video-o',
			'ft-ico-file-code-o',
			'ft-ico-vine',
			'ft-ico-codepen',
			'ft-ico-jsfiddle',
			'ft-ico-life-bouy',
			'ft-ico-life-saver',
			'ft-ico-support',
			'ft-ico-life-ring',
			'ft-ico-circle-o-notch',
			'ft-ico-ra',
			'ft-ico-rebel',
			'ft-ico-ge',
			'ft-ico-empire',
			'ft-ico-git-square',
			'ft-ico-git',
			'ft-ico-hacker-news',
			'ft-ico-tencent-weibo',
			'ft-ico-qq',
			'ft-ico-wechat',
			'ft-ico-weixin',
			'ft-ico-send',
			'ft-ico-paper-plane',
			'ft-ico-send-o',
			'ft-ico-paper-plane-o',
			'ft-ico-history',
			'ft-ico-circle-thin',
			'ft-ico-header',
			'ft-ico-paragraph',
			'ft-ico-sliders',
			'ft-ico-share-alt',
			'ft-ico-share-alt-square',
			'ft-ico-bomb'
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
