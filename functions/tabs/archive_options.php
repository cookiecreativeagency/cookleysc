<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_archive_options', 70);
	if( !function_exists('ci_add_tab_archive_options') ):
		function ci_add_tab_archive_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Archive Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	$ci_defaults['artists_per_page']     = '16';
	$ci_defaults['artists_isotope']      = '';
	$ci_defaults['discography_per_page'] = '16';
	$ci_defaults['discography_isotope']  = '';
	$ci_defaults['video_per_page']       = '16';
	$ci_defaults['video_isotope']        = '';
	$ci_defaults['galleries_per_page']   = '16';
	$ci_defaults['galleries_isotope']    = '';

	$ci_defaults['events_map_show']            = 'enabled';
	$ci_defaults['events_past']                = 'enabled';
	$ci_defaults['events_url_buttons_new_win'] = '';
	$ci_defaults['events_pagination']          = '';
	$ci_defaults['events_new_win']             = '';


	// Intercepts the request and injects the appropriate posts_per_page parameter according to the request.
	add_filter( 'pre_get_posts', 'ci_theme_taxonomy_paging_request' );
	if ( ! function_exists( 'ci_theme_taxonomy_paging_request' ) ):
	function ci_theme_taxonomy_paging_request( $query ) {
		//We don't want to mess with the admin panel and explicit posts_per_page values.
		if ( is_admin() || isset( $query->query_vars['posts_per_page'] ) ) {
			return $query;
		}

		$num_of_pages = 0;

		if ( is_tax( 'artist-category' ) ) {
			$num_of_pages = intval( ci_setting( 'artists_per_page' ) );
		} elseif( is_tax( 'section' ) ) {
			$num_of_pages = intval( ci_setting( 'discography_per_page' ) );
		} elseif( is_tax( 'gallery-category' ) ) {
			$num_of_pages = intval( ci_setting( 'galleries_per_page' ) );
		} elseif( is_tax( 'video-category' ) ) {
			$num_of_pages = intval( ci_setting( 'video_per_page' ) );
		}

		// Assign a number only if a number was found, otherwise, disable pagination.
		if ( $num_of_pages > 0 ) {
			$query->set( 'posts_per_page', $num_of_pages );
		} else {
			$query->set( 'posts_per_page', - 1 );
		}

		return $query;
	}
	endif;


?>
<?php else: ?>

	<fieldset class="set">
		<legend><?php _e( 'Artists Archive', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e('Select how many items per page you want, and if you want the category filters shown (Isotope effect). Please note that when category filters are enabled, the <em>number of items per page</em> setting is ignored.', 'ci_theme'); ?></p>
		<?php
			ci_panel_checkbox( 'artists_isotope', 'enabled', __( 'Enable category filters', 'ci_theme' ) );
			ci_panel_input( 'artists_per_page', __( 'Number of items per page:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Discography Archive', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e('Select how many items per page you want, and if you want the category filters shown (Isotope effect). Please note that when category filters are enabled, the <em>number of items per page</em> setting is ignored.', 'ci_theme'); ?></p>
		<?php
			ci_panel_checkbox( 'discography_isotope', 'enabled', __( 'Enable category filters', 'ci_theme' ) );
			ci_panel_input( 'discography_per_page', __( 'Number of items per page:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Galleries Archive', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e('Select how many items per page you want, and if you want the category filters shown (Isotope effect). Please note that when category filters are enabled, the <em>number of items per page</em> setting is ignored.', 'ci_theme'); ?></p>
		<?php
			ci_panel_checkbox( 'galleries_isotope', 'enabled', __( 'Enable category filters', 'ci_theme' ) );
			ci_panel_input( 'galleries_per_page', __( 'Number of items per page:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Videos Archive', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e('Select how many items per page you want, and if you want the category filters shown (Isotope effect). Please note that when category filters are enabled, the <em>number of items per page</em> setting is ignored.', 'ci_theme'); ?></p>
		<?php
			ci_panel_checkbox( 'video_isotope', 'enabled', __( 'Enable category filters', 'ci_theme' ) );
			ci_panel_input( 'video_per_page', __( 'Number of items per page:', 'ci_theme' ) );
		?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e( 'Events Archive', 'ci_theme' ); ?></legend>
		<p class="guide"><?php _e( 'Control what (and how) is being shown in the Events archive.', 'ci_theme' ); ?></p>
		<?php
			ci_panel_checkbox( 'events_map_show', 'enabled', __( 'Show events map', 'ci_theme' ) );
			ci_panel_checkbox( 'events_past', 'enabled', __( 'Show past events', 'ci_theme' ) );
			ci_panel_checkbox( 'events_pagination', 'enabled', __( 'Paginate past events', 'ci_theme' ) );
			ci_panel_checkbox( 'events_url_buttons_new_win', 'enabled', __( 'Open "Buy" and "Watch" button links in a new window', 'ci_theme' ) );
			ci_panel_checkbox( 'events_new_win', 'on', __( 'Open single Events in a new window', 'ci_theme' ) );
		?>
	</fieldset>

<?php endif; ?>