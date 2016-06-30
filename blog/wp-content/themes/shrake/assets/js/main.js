window.shrake = window.shrake || {};

(function( window, $, undefined ) {
	'use strict';

	var $window = $( window ),
		$body = $( 'body' ),
		shrake = window.shrake;

	$.extend( shrake, {
		config: {},

		init: function() {
			$body.addClass( 'ontouchstart' in window || 'onmsgesturechange' in window ? 'touch' : 'no-touch' );

			/**
			 * Makes "skip to content" link work correctly in IE9, Chrome, and Opera
			 * for better accessibility.
			 *
			 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
			 */
			if ( /webkit|opera|msie/i.test( navigator.userAgent ) && window.addEventListener ) {
				$window.on( 'hashchange', function() {
					skipToElement( location.hash.substring( 1 ) );
				});

				$( 'a.screen-reader-text' ).on ( 'click', function() {
					skipToElement( $( this ).attr( 'href' ).substring( 1 ) );
				});
			}
		},

		/**
		 * Set up comments.
		 *
		 * - Sets comments display based window hash. Automatically display
		 *   comments if the hash contains '#comment' or '#respond' string.
		 * - Toggles comments display when comments header is clicked.
		 */
		setupComments: function() {
			var $comments = $( '.comments-area' );

			if ( /^#(comment|respond)/.test( window.location.hash ) ) {
				$comments.addClass( 'is-open' );
				$( window.location.hash ).click();
			}

			// Toggle comments.
			$comments.on( 'click', '.comments-header', function() {
				$comments.toggleClass( 'is-open' );
			});
		},

		/**
		 * Set up navigation.
		 */
		setupNavigation: function() {
			var $siteHeader = $( '.site-header' ),
				$siteNavigation = $( '.site-navigation' ),
				$toggleButton = $( '.site-navigation-toggle' );

			// Toggle the main menu.
			$toggleButton.on( 'click', function() {
				$siteHeader.toggleClass( 'nav-menu-is-open' );
				$siteNavigation.toggleClass( 'is-open' );
			});
		},

		/**
		 * Set up submenu navigation.
		 */
		setupSubmenuNavigation: function() {
			var $navigation = $( '.submenu-navigation' ),
				$toggleButton = $( '.submenu-navigation-toggle' );

			// Toggle the main menu.
			$toggleButton.on( 'click', function() {
				$navigation.toggleClass( 'is-open' );
			});
		},

		/**
		 * Set up videos.
		 *
		 * - Makes videos responsive.
		 */
		setupVideos: function() {
			if ( $.isFunction( $.fn.fitVids ) ) {
				$( '.hentry, .entry-video' ).fitVids();
			}
		}
	});

	function skipToElement( elementId ) {
		var element = document.getElementById( elementId );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();
		}
	}
	
function selectMenu() {
    "use strict";
    var $menu_select = $("<div class='select'><ul></ul></div>");
    $menu_select.appendTo(".selectnav");
    if ($(".site-navigation").hasClass('drop_down')) {
        $(".site-navigation ul li a").not('.wr-megamenu-inner a').each(function() {
            var menu_url = $(this).attr("href");
            var menu_text = $(this).text();
            if ($(this).parents("li").length === 2) {
                menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text
            }
            if ($(this).parents("li").length === 3) {
                menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text
            }
            if ($(this).parents("li").length > 3) {
                menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text
            }
            var li = $("<li />",{'class':menu_text.replace(/\s+/g,'').toLowerCase()});
            var link = $("<a />", {"href": menu_url, "html": menu_text});
            link.appendTo(li);
            li.appendTo($menu_select.find('ul'))
        });
            var li_mail = $("<li />",{'class':''});
            var link_mail = $("<a />", {"href": "#", "html": "(0674)&nbsp;694&nbsp;1111"});
            link_mail.appendTo(li_mail);
            li_mail.appendTo($menu_select.find('ul'))

            var li_phone = $("<li />",{'class':''});
            var link_phone = $("<a />", {"href": "mailto:info@mrclass.in", "html": "info@mrclass.in"});
            link_phone.appendTo(li_phone);
            li_phone.appendTo($menu_select.find('ul'))

            var li_signup = $("<li />",{'class':''});
            var link_signup = $("<a />", {"href": "/signup", "html": "Sign Up"});
            link_signup.appendTo(li_signup);
            li_signup.appendTo($menu_select.find('ul'))

            var li_signup = $("<li />",{'class':'btn_top'});
            var link_signup = $("<a />", {"href": "/login", "html": "Sign In"});
            link_signup.appendTo(li_signup);
            li_signup.appendTo($menu_select.find('ul'))

        if($('.wr-megamenu-inner a').length>0){
            $menu_select.find('li.categories').append($("<ul />"));
        }
        $('.wr-megamenu-inner a').each(function() {
            var menu_url = $(this).attr("href");
            var menu_text = $(this).text();
            if ($(this).parents("li").length === 2) {
                menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text
            }
            if ($(this).parents("li").length === 3) {
                menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text
            }
            if ($(this).parents("li").length > 3) {
                menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text
            }
            var li = $("<li />",{'class':menu_text.replace(/\s+/g,'').toLowerCase()});
            var link = $("<a />", {"href": menu_url, "html": menu_text});
            link.appendTo(li);
            li.appendTo($menu_select.find('li.categories ul'))
        });
        $('.categories').find("ul").hide();
    } else if ($(".site-navigation").hasClass('drop_down2')) {
        $(".site-navigation ul li a").each(function() {
            var menu_url = $(this).attr("href");
            var menu_text = $(this).text();
            if ($(this).parents("div.mc").length === 1) {
                menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text
            }
            if ($(this).hasClass('sub')) {
                menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text
            }
            var li = $("<li />");
            var link = $("<a />", {"href": menu_url, "html": menu_text});
            link.appendTo(li);
            li.appendTo($menu_select.find('ul'))
        });
    }
    $(".selectnav_button span").click(function() {
        var $el = $(".select ul:eq(0)");
        $el.is(":visible")?$el.slideUp(function(){$('.categories').find("ul").slideUp()}):$el.slideDown();
    });
    $(".selectnav ul li a").not('.categories a').click(function() {
        $(".select ul").slideUp();
    });
    $('.categories').find('a').eq(0).click(function() {
        $('.categories').find("ul").is(':visible')?$('.categories').find("ul").slideUp():$('.categories').find("ul").slideDown();
    });
    $(document).click(function(e){
        $(e.target).closest('.topmenublock').length>0 || $(e.target).closest('.selectnav_button').length>0 || $(e.target).hasClass('.topmenublock') || $(e.target).hasClass('.selectnav_button')?"":$(".select ul:eq(0)").slideUp();
    });
}
	

	// Document ready.
	jQuery(function() {
		shrake.init();
		shrake.header.init();
		shrake.setupComments();
		shrake.setupNavigation();
		shrake.setupSubmenuNavigation();
		selectMenu();
		shrake.setupVideos();
	});

})( this, jQuery );
