( function( $ ) {
	'use strict';

	/* -----------------------------------------
	Responsive Menus Init with mmenu
	----------------------------------------- */
	var $mainNav   = $( '.navigation' );
	var $mobileNav = $( '#mobilemenu' );

	$mainNav.clone().removeAttr( 'id' ).removeClass().appendTo( $mobileNav );
	$mobileNav.find( 'li' ).removeAttr( 'id' );

	$mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		],
		"extensions": ["theme-dark"]
	});


	/* -----------------------------------------
	Main Navigation Init
	----------------------------------------- */
	$mainNav.superfish({
		delay: 300,
		animation: { opacity: 'show', height: 'show' },
		speed: 'fast',
		dropShadows: false
	});


	/* -----------------------------------------
	Responsive Videos with fitVids
	----------------------------------------- */
	$( 'body' ).fitVids();


	/* -----------------------------------------
	Tracklisting
	----------------------------------------- */
	var $tracklisten = $('.track-listen');
	if ($tracklisten.length) {
		$tracklisten.click(function() {
			var target = $(this).siblings('.track-audio');
			var siblings = $(this).parents('.track').siblings().children('.track-audio');
			siblings.slideUp('fast');
			target.slideToggle('fast');
			return false;
		});
	}
	
	/* -----------------------------------------
	Tracklisting subtitles
	----------------------------------------- */
	var $track = $('.track');
	if ($track.length) {
		$track.each(function(){
			var main_head = $(this).find('.main-head');
			if (main_head.length === 0) 
				$(this).addClass('track-single');
		});
	}

	/* -----------------------------------------
	Image Lightbox
	----------------------------------------- */
	$( ".ci-lightbox, a.zoom, a[data-rel^='prettyPhoto']" ).magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true
		},
		zoom: {
			enabled: true
		}
	});

	
	/* -----------------------------------------
	SoundManager2 Init
	----------------------------------------- */
	soundManager.setup({
		url: ThemeOption.swfPath
	});

	/* -----------------------------------------
	Media Element
	----------------------------------------- */
	$( '.video-player video' ).mediaelementplayer();

	$( window ).on( 'load', function() {

		/* -----------------------------------------
		FlexSlider Init
		----------------------------------------- */
		var homeSlider = $( '.home-slider' );

		if ( homeSlider.length ) {
			var animation      = homeSlider.data( 'animation' ),
					direction      = homeSlider.data( 'direction' ),
					slideshow      = homeSlider.data( 'slideshow' ),
					slideshowSpeed = homeSlider.data( 'slideshowspeed' ),
					animationSpeed = homeSlider.data( 'animationspeed' );

			homeSlider.flexslider({
				animation     : animation,
				direction     : direction,
				slideshow     : slideshow,
				slideshowSpeed: slideshowSpeed,
				animationSpeed: animationSpeed,
				directionNav: false,
				namespace: 'ci-',
				prevText: '',
				nextText: '',
				start: function( slider ) {
					slider.removeClass( 'loading' );
				}
			});
		}
		

		/* -----------------------------------------
		Isotope
		----------------------------------------- */
		var $container = $( '.filter-container' );
		if ( $container.length > 0 ) {
			$container.isotope();
		
			// filter items when filter link is clicked
			var $filters = $( '.filters-nav li a' );
			$filters.click( function( e ) {
				var selector = $( this ).attr( 'data-filter' );
				$( this ).parent().siblings().find( 'a' ).removeClass( 'selected' );
				$( this ).addClass( 'selected' );
			
				$container.isotope({ 
					filter: selector,
					animationOptions: {
						duration: 750,
						easing: 'linear',
						queue: false
					}
				});
			
				e.preventDefault();
			});
		}

	});

})( jQuery );
