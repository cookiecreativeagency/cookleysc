<?php 
	get_template_part('panel/constants');

	load_theme_textdomain( 'ci_theme', get_template_directory() . '/lang' );

	// This is the main options array. Can be accessed as a global in order to reduce function calls.
	$ci = get_option(THEME_OPTIONS);
	$ci_defaults = array();

	// The $content_width needs to be before the inclusion of the rest of the files, as it is used inside of some of them.
	if ( ! isset( $content_width ) ) $content_width = 750;

	//
	// Let's bootstrap the theme.
	//
	get_template_part('panel/bootstrap');

	get_template_part('functions/shortcodes');
	get_template_part('functions/woocommerce');
	get_template_part('functions/downloads_handler');


	//
	// Define our various image sizes.
	//
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 580, 350, true );
	add_image_size( 'ci_post_thumbnail', 750, 450, true );
	add_image_size( 'ci_discography', 560, 560, true );
	add_image_size( 'ci_event', 560, 9999, false );
	add_image_size( 'ci_event_thumb', 65, 86, true );
	add_image_size( 'ci_fullwidth', 1140, 641, true );

	// Let WooCommerce know that we support it.
	add_theme_support( 'woocommerce' );

	// Let the user choose a color scheme on each post individually.
	add_ci_theme_support( 'post-color-scheme', array( 'page', 'post', 'product', 'cpt_artists', 'cpt_discography', 'cpt_galleries', 'cpt_videos', 'cpt_events' ) );

	// Enable HTML5 support
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );


	// Convert the old automatic slide option to the appropriate flexslider's snippet option.
	add_action( 'after_setup_theme', 'ci_theme_convert_slider_options_v3_to_v4' );
	if ( ! function_exists( 'ci_theme_convert_slider_options_v3_to_v4' ) ):
	function ci_theme_convert_slider_options_v3_to_v4() {
		global $ci, $ci_defaults;
		if( isset( $ci['slider_auto'] ) && ! isset( $ci_defaults['slider_auto'] ) ) {
			$new_options = array(
				'slider_autoslide' => $ci['slider_auto'],
			);
			unset( $ci['slider_auto'] );
			$ci = array_merge( $ci, $new_options );
			update_option( THEME_OPTIONS, $ci );
		}
	}
	endif;


	if ( ! function_exists( 'ci_theme_get_frontpage_slides' ) ):
	function ci_theme_get_slides( $base_category = false, $post_id = false, $return_ids = false, $posts_per_page = -1 ) {

		if( $base_category === false && $post_id === false && get_option( 'show_on_front' ) == 'page' ) {
			$front = get_option( 'page_on_front' );
			if ( ! empty( $front ) ) {
				$base = get_post_meta( $front, 'base_slider_category', true );
				if ( ! empty( $base ) ) {
					$base_category = $base;
				}
			}
		} elseif( $base_category === false && $post_id !== false ) {
			$base = get_post_meta( $post_id, 'base_slider_category', true );
			if ( ! empty( $base ) ) {
				$base_category = $base;
			}
		}

		$args = array(
			'post_type'      => 'cpt_slider',
			'posts_per_page' => $posts_per_page,
		);

		if ( ! empty( $base_category ) && $base_category > 0 ) {
			$args = array_merge( $args, array(
				'tax_query' => array(
					array(
						'taxonomy' => 'slider-category',
						'terms'    => intval( $base_category ),
					)
				)
			) );
		}

		if( $return_ids === true ) {
			$args['fields'] = 'ids';
		}

		return new WP_Query( $args );
	}
	endif;
