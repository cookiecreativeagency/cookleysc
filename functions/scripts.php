<?php
//
// Uncomment one of the following two. Their functions are in panel/generic.php
//
//add_action('wp_enqueue_scripts', 'ci_enqueue_modernizr');
//add_action('wp_enqueue_scripts', 'ci_print_html5shim');


// This function lives in panel/generic.php
//add_action('wp_footer', 'ci_print_selectivizr', 100);

add_action('init', 'ci_register_theme_scripts');
if( !function_exists('ci_register_theme_scripts') ):
function ci_register_theme_scripts()
{
	//
	// Register all scripts here, both front-end and admin. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//
	wp_register_script( 'jquery-superfish', get_child_or_parent_file_uri( '/js/superfish.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-mmenu', get_child_or_parent_file_uri( '/js/jquery.mmenu.min.all.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-flexslider', get_child_or_parent_file_uri( '/js/jquery.flexslider-min.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-equalheights', get_child_or_parent_file_uri( '/js/jquery.equalHeights.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-isotope', get_child_or_parent_file_uri( '/js/jquery.isotope.min.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-magnific-popup', get_child_or_parent_file_uri( '/js/jquery.magnific-popup.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-ui-timepicker', get_child_or_parent_file_uri( '/js/jquery-ui-timepicker-addon.js' ), array(
		'jquery-ui-slider',
		'jquery-ui-datepicker'
	) );
	wp_register_script( 'jquery-gmaps-latlon-picker', get_child_or_parent_file_uri( '/js/jquery-gmaps-latlon-picker.js' ), array(
		'jquery',
		'google-maps'
	), CI_THEME_VERSION, true );

	wp_register_script( 'soundmanager-core', get_child_or_parent_file_uri( '/js/soundmanager2/script/soundmanager2-nodebug-jsmin.js' ), array( 'jquery' ), '2.97', true );
	wp_register_script( 'soundmanager-mp3-button', get_child_or_parent_file_uri( '/js/soundmanager2/script/mp3-player-button.js' ), array( 'jquery' ), '2.97', true );
	wp_register_script( 'jquery-shoutcast', get_child_or_parent_file_uri( '/js/jquery.shoutcast.min.js' ), array( 'jquery' ), CI_THEME_VERSION, true );
	wp_register_script( 'ci_audioplayer', get_child_or_parent_file_uri( '/js/ci_audioplayer.js' ), array( 'jquery' ), CI_THEME_VERSION, true );

	wp_register_script( 'ci-post-edit-scripts', get_child_or_parent_file_uri( '/js/post-edit-scripts.js' ), array( 'jquery' ), CI_THEME_VERSION, true );

	wp_register_script( 'ci-front-scripts', get_child_or_parent_file_uri( '/js/scripts.js' ), array(
		'jquery',
		'jquery-superfish',
		'jquery-mmenu',
		'jquery-superfish',
		'jquery-flexslider',
		'jquery-magnific-popup',
		'jquery-equalheights',
		'jquery-fitVids',
		'soundmanager-core',
		'soundmanager-mp3-button',
		'jquery-shoutcast',
		'ci_audioplayer',
		'wp-mediaelement'
	), CI_THEME_VERSION, true );
	
}
endif;



add_action('wp_enqueue_scripts', 'ci_enqueue_theme_scripts');
if( !function_exists('ci_enqueue_theme_scripts') ):
function ci_enqueue_theme_scripts()
{
	//
	// Enqueue all (or most) front-end scripts here.
	// They can be also enqueued from within template files.
	//	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'jquery-isotope' );

	if ( wp_script_is( 'prettyPhoto', 'enqueued' ) ) {
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	wp_enqueue_script( 'ci-front-scripts' );

	$params['theme_url'] = get_template_directory_uri();
	$params['swfPath']   = get_template_directory_uri() . '/js/soundmanager2/swf/';

	wp_localize_script( 'ci-front-scripts', 'ThemeOption', $params );

	if ( ci_setting( 'google_maps_api_enable' ) == 'on' ) {
		wp_enqueue_script( 'google-maps' );
	}

}
endif;


if( !function_exists('ci_enqueue_admin_theme_scripts') ):
add_action('admin_enqueue_scripts','ci_enqueue_admin_theme_scripts');
function ci_enqueue_admin_theme_scripts() 
{
	global $pagenow;

	//
	// Enqueue here scripts that are to be loaded on all admin pages.
	//

	if(is_admin() and $pagenow=='themes.php' and isset($_GET['page']) and $_GET['page']=='ci_panel.php')
	{
		//
		// Enqueue here scripts that are to be loaded only on CSSIgniter Settings panel.
		//

	}
}
endif;
