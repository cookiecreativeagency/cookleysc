<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-md-12">

		<?php if ( ci_setting( 'video_isotope' ) == 'enabled' ): ?>

			<ul class="filters-nav group">
				<li><a href="#filter" class="selected action-btn buy" data-filter="*"><?php _e( 'All Videos', 'ci_theme' ); ?></a></li>

				<?php $sections = get_terms( 'video-category', array( 'hide_empty' => 1 ) ); ?>
				<?php foreach ( $sections as $section ): ?>
					<li><a href="#filter" data-filter=".<?php echo esc_attr( $section->slug ); ?>" class="action-btn buy"><?php echo $section->name; ?></a></li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>

	</div>

</div>	

<div class="row">

	<ol class="listing group <?php if ( ci_setting( 'video_isotope' ) == 'enabled' ): ?> filter-container filter-container-videos <?php endif; ?>">

		<?php
			if ( ci_setting( 'video_isotope' ) == 'enabled' ) {
				query_posts( array(
					'post_type'      => 'cpt_videos',
					'posts_per_page' => - 1
				) );
			} else {
				query_posts( array(
					'post_type'      => 'cpt_videos',
					'posts_per_page' => ci_setting( 'video_per_page' ),
					'paged'          => ci_get_page_var(),
				) );
			}
			$i = 1;
		?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
				$video_url  = get_post_meta( get_the_ID(), 'ci_cpt_videos_url', true );
				$video_type = get_post_meta( get_the_ID(), 'ci_cpt_videos_self', true );
			?>

			<?php
				$cat_slugs = '';
				if ( ci_setting( 'video_isotope' ) == 'enabled' ) {
					$cats = wp_get_object_terms( get_the_ID(), 'video-category' );
					$cat_slugs = wp_list_pluck( $cats, 'slug' );
					$cat_slugs = implode( ' ', $cat_slugs );
				}
			?>

			<li class="col-md-4 col-sm-6 <?php echo esc_attr( $cat_slugs ); ?>">
				<div class="list-item list-item-video">
					<a href="<?php echo ( $video_type == 1 ? "#player".$i."-wrap" : esc_url( $video_url ) ); ?>" class="ci-lightbox overlay-link <?php echo ( $video_type == 1  ? 'mfp-inline' : 'mfp-iframe'); ?>">
						<?php the_post_thumbnail(); ?>
						<div class="overlay icon-play"></div>
					</a>

					<div class="list-item-info">
						<h2 class="list-item-head"><?php the_title(); ?></h2>
					</div>

					<?php if ( $video_type == 1 ): ?>
						<div id="player<?php echo $i; ?>-wrap" class="video-player mfp-hide">
							<video width="600" height="360" src="<?php echo esc_url( $video_url ); ?>" controls="controls" preload="none"></video>
						</div>
					<?php endif; ?>
				</div>
			</li>

		<?php $i++; endwhile; endif; ?>

	</ol>

</div>

<?php ci_pagination(); ?>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>
