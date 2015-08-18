<?php
if ( ! function_exists( 'ci_theme_shortcode_empty_paragraph_fix' ) ):
function ci_theme_shortcode_empty_paragraph_fix( $content ) {
	$array   = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);
	$content = strtr( $content, $array );

	return $content;
}
endif;
add_filter( 'the_content', 'ci_theme_shortcode_empty_paragraph_fix' );

if ( ! function_exists( 'ci_theme_tracklisting_shortcode_handler' ) ):
function ci_theme_tracklisting_shortcode_handler( $params, $content = '' ) {
	if ( ! empty( $content ) ) {
		return ci_theme_tracklisting_old_shortcode( $params, $content );
	} else {
		return ci_theme_tracklisting_shortcode( $params, $content );
	}
}
endif;

if ( ! function_exists( 'ci_theme_tracklisting_shortcode' ) ):
function ci_theme_tracklisting_shortcode( $params, $content = '' ) {
	extract( shortcode_atts( array(
		'id'           => '',
		'slug'         => '',
		'limit'        => - 1,
		'tracks'       => '',
		'hide_numbers' => '',
		'hide_buttons' => '',
		'hide_players' => '',
		'hide_titles'  => ''
	), $params ) );

	$tracks = empty( $tracks ) ? '' : explode( ',', $tracks );

	global $post;

	// By default, when the shortcode tries to get the tracklisting of any discography item, should be
	// restricted to only published discographies.
	// However, when the discography itself shows its own tracklisting, it should be allowed to do so,
	// no matter what its post status may be.
	$args = array(
		'post_type'        => 'cpt_discography',
		'post_status'      => 'publish',
		'numberposts'      => '1',
		'suppress_filters' => false
	);

	if ( empty( $id ) and empty( $slug ) ) {
		$args['p'] = $post->ID;

		// We are showing the current post's tracklisting (since we didn't get any parameters),
		// so we need to make sure we can retrieve it whatever its post status might be.
		$args['post_status'] = 'any';

	} elseif ( ! empty( $id ) and $id > 0 ) {
		$args['p'] = $id;

		// Check if the current post's ID matches what was passed.
		// If so, we need to make sure we can retrieve it whatever its post status might be.
		if ( $post->ID == $args['p'] ) {
			$args['post_status'] = 'any';
		}

	} elseif ( ! empty( $slug ) ) {
		$args['name'] = sanitize_title_with_dashes( $slug, '', 'save' );

		// Check if the current post's slug matches what was passed.
		// If so, we need to make sure we can retrieve it whatever its post status might be.
		if ( $post->post_name == $args['name'] ) {
			$args['post_status'] = 'any';
		}
	}

	$posts = get_posts( $args );

	if ( count( $posts ) >= 1 ) {
		$post_id = $posts[0]->ID;

		$fields = get_post_meta( $post_id, 'ci_cpt_discography_tracks', true );
		$fields = ci_theme_convert_discography_tracks_from_unnamed( $fields );
	
		ob_start();

		if ( ! empty( $fields ) ) {
			$track_num = 0; // Helps count actual songs (instead of increments of field groups, i.e. 6)
			$outputted = 0; // Helps count actually outputted songs. Used with 'limit' parameter.
			?>
			<ol class="tracklisting">
				<?php foreach( $fields as $field ): ?>
					<?php
						$track_num ++;
						$track_id = $post_id . '_' . $track_num;

						if ( is_array( $tracks ) and ! in_array( $track_num, $tracks ) ) {
							continue;
						}
					?>

					<li id="custom_player<?php echo esc_attr( $track_id ); ?>" class="track group custom_player<?php echo esc_attr( $track_id ); ?>">

						<?php if ( empty( $hide_numbers ) ): ?>
							<span class="track-no"><?php echo $track_num; ?></span>
						<?php endif; ?>

						<?php if ( empty( $hide_titles ) ): ?>
							<p class="track-info">
								<span class="sub-head"><?php echo $field['title']; ?></span>
								<?php if ( ! empty( $field['subtitle'] ) ): ?>
									<span class="main-head"><?php echo $field['subtitle']; ?></span>
								<?php endif; ?>
							</p>
						<?php endif; ?>

						<?php if ( empty( $hide_buttons ) ): ?>
							<div class="btns">
								<?php if ( ! empty( $field['download_url'] ) ): ?>
									<a href="<?php echo esc_url( add_query_arg( 'force_download', $field['download_url'] ) ); ?>" class="action-btn buy download-track inline-exclude"><?php _e( 'Download track', 'ci_theme' ); ?></a>
								<?php endif; ?>
								<?php if ( ! empty( $field['buy_url'] ) ): ?>
									<a href="<?php echo esc_url( $field['buy_url'] ); ?>" class="action-btn buy buy-track"><?php _e( 'Buy track', 'ci_theme' ); ?></a>
								<?php endif; ?>
								<?php if ( ! empty( $field['lyrics'] ) ): ?>
									<?php $lyrics_id = sanitize_html_class( $field['title'] . '-lyrics-' . $track_num ); ?>
									<a href="#<?php echo esc_attr( $lyrics_id ); ?>" title="<?php echo esc_attr( sprintf( _x( '%s Lyrics', 'song name lyrics', 'ci_theme' ), $field['title'] ) ); ?>" data-mfp-src="#<?php echo esc_attr( $lyrics_id ); ?>" class="action-btn buy ci-lightbox mfp-inline"><?php _e( 'Lyrics', 'ci_theme' ); ?></a>
									<div id="<?php echo esc_attr( $lyrics_id ); ?>" class="track-lyrics-hold mfp-hide">
										<p>
											<strong><?php echo $field['title']; ?>
											<?php if ( ! empty( $field['subtitle'] ) ) {
												echo '&ndash;' . $field['subtitle'];
											} ?>
											</strong>
										</p>
										<?php echo wpautop( $field['lyrics'] ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( empty( $hide_players ) ): ?>
							<?php if ( ( strpos( $field['play_url'], 'http://soundcloud.com' ) !== false ) or ( strpos( $field['play_url'], 'https://soundcloud.com' ) !== false ) ): ?>
								<a href="<?php echo esc_url( $field['play_url'] ); ?>" class="track-listen sc"><i class="fa fa-soundcloud"></i></a>
								<div id="track<?php echo esc_attr( $track_id ); ?>" class="track-audio sc-oembed">
									<?php echo wp_oembed_get( esc_url( $field['play_url'] ) ); ?>
								</div>
							<?php elseif ( ( substr_left( $field['play_url'], 25 ) == 'http://api.soundcloud.com' ) or ( substr_left( $field['play_url'], 26 ) == 'https://api.soundcloud.com' ) ): ?>
								<a href="#track<?php echo esc_attr( $track_id ); ?>" class="track-listen sc"><i class="fa fa-soundcloud"></i></a>
								<div id="track<?php echo esc_attr( $track_id ); ?>" class="track-audio">
									<?php echo do_shortcode( '[soundcloud width="100%" url="' . esc_url( $field['play_url'] ) . '" iframe="true" /]' ); ?>
								</div>
							<?php else: ?>
								<a class="sm2_button" href="<?php echo esc_url( $field['play_url'] ); ?>"><i class="fa fa-play"></i></a>
							<?php endif; ?>
						<?php endif; ?>
	
					</li>
	
					<?php
						if ( $limit > 0 ) {
							$outputted ++;
							if ( $outputted >= $limit ) {
								break;
							}
						}
					?>
				<?php endforeach; ?>
			</ol>
			<?php
		}
		
		$output = ob_get_clean();
	} else {
		$output = apply_filters( 'ci_tracklisting_shortcode_error_msg', __( 'Cannot show track listings from non-public, non-published posts.', 'ci_theme' ) );
	}
	
	return $output;
}
endif;
add_shortcode( 'tracklisting', 'ci_theme_tracklisting_shortcode_handler' );

if ( ! function_exists( 'ci_theme_tracklisting_old_shortcode' ) ):
function ci_theme_tracklisting_old_shortcode( $params, $content = '' ) {
	return '<ol class="tracklisting">' . do_shortcode( $content ) . '</ol>';
}
endif;

if ( ! function_exists( 'ci_theme_track_shortcode' ) ):
function ci_theme_track_shortcode( $params, $content = '' ) {
	extract( shortcode_atts( array(
		'track_no'     => '1',
		'title'        => __( 'Track title', 'ci_theme' ),
		'subtitle'     => __( 'Track subtitle', 'ci_theme' ),
		'type'         => 'soundcloud',
		'buy_url'      => '',
		'download_url' => ''
	), $params ) );

	static $i = 0;
	$i ++;
	$p = '';
	$b = '';
	$d = '';
	$s = '';
	$m = '';
	$t = '';

	if ( ! empty( $download_url ) ) {
		$download_url = add_query_arg( 'force_download', $download_url );
		$d = sprintf( '<a href="%s" class="action-btn buy download-track">%s</a>',
			esc_url( $download_url ),
			__( 'Download track', 'ci_theme' )
		);
	}

	if ( ! empty( $buy_url ) ) {
		$b = sprintf( '<a href="%s" class="action-btn buy buy-track">%s</a>',
			esc_url( $buy_url ),
			__( 'Buy track', 'ci_theme' )
		);
	}

	if ( 'soundcloud' == strtolower( $type ) ) {
		$t = 'custom_soundcloud';
		$p = sprintf( '<div class="btns">%1$s%2$s</div><a href="#track%3$s" class="track-listen sc"><i class="fa fa-soundcloud"></i></a><div id="track%3$s" class="track-audio">%4$s</div>',
			$d,
			$b,
			esc_attr( $track_no ),
			do_shortcode( $content )
		);
	}
	else {
		$t = 'custom_player';
		$p = sprintf('<div class="btns">%1$s%2$s</div><a class="sm2_button" href="%3$s"><i class="fa fa-play"></i></a>',
			$d,
			$b,
			esc_url( $content )
		);
	}

	if ( ! empty( $subtitle ) ) {
		$s = sprintf('<span class="main-head">%s</span>',
			$subtitle
		);
	}

	return sprintf( '
		<li id="%1$s" class="track group %1$s">
			<span class="track-no">%2$s</span>
			<p class="track-info">
				<span class="sub-head">%3$s</span>%4$s
			</p>
			%5$s
		</li>',
		esc_attr( $t . $i ),
		$track_no,
		$title,
		$s,
		$p
	);
}
endif;
add_shortcode( 'track', 'ci_theme_track_shortcode' );



/*
 * The old grid shortcodes (column*) are not applicable any more.
 * If they are not already registered by a plugin or something, we pass them
 * through _ci_theme_column_shortcode_do_nothing() so that the shortcodes
 * themselves will not be visible in the posts' contents.
 */
function _ci_theme_column_shortcode_do_nothing( $atts, $content = null, $tag ) {
	return do_shortcode( $content );
}

$old_shortcodes = array(
	'columns',
	'column',
	'column_one',
	'column_two',
	'column_three',
	'column_four',
	'column_five',
	'column_six',
	'column_seven',
	'column_eight',
	'column_nine',
	'column_ten',
	'column_eleven',
	'column_twelve',
	'column_thirteen',
	'column_fourteen',
	'column_fifteen',
	'column_sixteen',
);
foreach ( $old_shortcodes as $old_shortcode ) {
	if( ! shortcode_exists($old_shortcode) ) {
		add_shortcode( $old_shortcode, '_ci_theme_column_shortcode_do_nothing' );
	}
}
