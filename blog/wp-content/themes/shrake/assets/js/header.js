/*global _:false */

window.shrake = window.shrake || {};

(function( window, $, undefined ) {
	'use strict';

	window.shrake.header = {
		settings: {
			mediaMaxHeight: 200,
			mediaAspectRatio: 0
		},

		init: function() {
			if ( 'ontouchstart' in window || 'onmsgesturechange' in window ) {
				return;
			}

			this.$window = $( window );
			this.$toolbar = $( '#wpadminbar' );
			this.$demobar = $( '#demosite-activate-wrap' );
			this.$header = $( '.site-header' );
			this.$navigation = $( '.site-navigation' );
			this.$content = $( '.site-content' );
			this.$media = $( '.entry-image' );

			this.initialized = false;
			this.contentTop = this.headerHeight = this.$header.outerHeight();
			this.doFancyScroll = false;
			this.hasMedia = !! this.$media.length;
			this.mediaAspectRatio = 0.75;

			if ( this.hasMedia ) {
				this.mediaOffsetTop = this.$media.offset().top;
				this.$window.on( 'load', $.proxy( this.cacheMediaAspectRatio, this ));
			}

			_.bindAll( this, 'onResize', 'onScroll' );
			this.$window.on( 'load orientationchange resize', _.throttle( this.onResize, 150 ) );
			this.$window.on( 'load orientationchange scroll', _.throttle( this.onScroll, 20 ) );
		},

		onResize: function() {
			var vw = this.viewportWidth();

			if ( vw >= 1024 ) {
				this.initialized = true;
				this.headerHeight = this.$header.outerHeight();
				this.canFancyScroll();
				this.refreshElements();
				this.$header.addClass( 'is-fixed' ).css( 'top', this.toolbarHeight() + this.demobarHeight() );
			} else if ( this.initialized && vw < 1024 ) {
				this.initialized = false;
				this.$header.removeClass( 'is-fixed is-compact' ).css( 'top', '' );
				this.$content.css( 'margin-top', '' );
				this.resetMedia();
			}

			if ( vw >= 768 ) {
				this.$header.removeClass( 'nav-menu-is-open' );
				this.$navigation.removeClass( 'is-open' );
			}
		},

		onScroll: function() {
			if ( ! this.initialized ) {
				return;
			}

			// Only change the media height if it's fully visible.
			if ( this.doFancyScroll ) {
				this.updateMediaHeight();
			}

			this.$header.toggleClass( 'is-compact', this.$window.scrollTop() > this.contentTop - this.headerHeight );
		},

		cacheMediaAspectRatio: function() {
			var $image = this.$media.find( 'img' ),
				height = parseInt( $image.attr( 'height' ), 10 ),
				width = parseInt( $image.attr( 'width' ), 10 );

			this.mediaAspectRatio = ( width > height ) ? height / width : width / height;
		},

		canFancyScroll: function() {
			var bottomOffset = 0;

			if ( this.hasMedia ) {
				bottomOffset = this.viewportHeight() - this.getMediaRealHeight() - this.mediaOffsetTop;
			}

			this.doFancyScroll = ( bottomOffset > 0 );
		},

		getMediaRealHeight: function() {
			var height = this.$media.parent().width() * this.mediaAspectRatio;
			return height > this.settings.mediaMaxHeight ? this.settings.mediaMaxHeight : height;
		},

		refreshElements: function() {
			var mediaHeight = 0;

			if ( this.doFancyScroll ) {
				this.$media.addClass( 'is-fixed' ).css({
					top: this.headerHeight + this.toolbarHeight() + this.demobarHeight(),
					width: this.$media.parent().width()
				});

				mediaHeight = this.getMediaRealHeight();
				this.updateMediaHeight();
			} else {
				this.resetMedia();
			}

			this.contentTop = this.headerHeight + mediaHeight;
			//this.$content.css( 'margin-top', this.contentTop );
			this.$content.css( 'margin-top', '97px' );
		},

		resetMedia: function() {
			this.$media.removeClass( 'is-fixed' ).css({ height: '', top: '', width: '' });
		},

		updateMediaHeight: function() {
			this.$media.height( this.contentTop - this.$window.scrollTop() - this.headerHeight );
		},

		demobarHeight: function() {
			return this.$demobar.length ? parseInt( this.$demobar.height(), 10 ) : 0;
		},

		toolbarHeight: function() {
			return this.$toolbar.length ? parseInt( this.$toolbar.height(), 10 ) : 0;
		},

		viewportHeight: function() {
			return window.innerHeight || this.$window.height();
		},

		viewportWidth: function() {
			return window.innerWidth || this.$window.width();
		}
	};

})( this, jQuery );
