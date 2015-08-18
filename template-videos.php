<?php
/*
Template Name: Videos
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<?php while( have_posts() ): the_post(); ?>
	<?php
		$post_type      = 'cpt_videos';
		$taxonomy       = 'video-category';
		$thumbnail_size = 'post-thumbnail';
		$all_label      = __( 'All Videos', 'ci_theme' );
		$columns        = get_post_meta( get_the_ID(), 'listing_columns', true );
		$isotope        = get_post_meta( get_the_ID(), 'listing_isotope', true );
		$posts_per_page = get_post_meta( get_the_ID(), 'listing_posts_per_page', true );

		$item_classes = '';
		switch( $columns ) {
			case 1:
				$item_classes = 'col-xs-12';
				break;
			case 2:
				$item_classes = 'col-xs-12 col-sm-6';
				break;
			case 3:
				$item_classes = 'col-xs-12 col-sm-6 col-md-4';
				break;
			case 4:
			default:
				$item_classes = 'col-xs-12 col-sm-6 col-md-3';
				break;
		}
	?>

	<?php if ( 'on' == $isotope ): ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="filters-nav group">
					<li><a href="#filter" class="selected action-btn buy" data-filter="*"><?php echo $all_label; ?></a></li>
					<?php $cats = get_terms( $taxonomy, array( 'hide_empty' => 1 ) ); ?>
					<?php foreach ( $cats as $cat ): ?>
						<li><a href="#filter" data-filter=".<?php echo esc_attr( $cat->slug ); ?>" class="action-btn buy"><?php echo $cat->name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<ol class="listing group <?php if ( 'on' == $isotope ): ?> filter-container <?php endif; ?>">
			<?php
				if ( 'on' == $isotope ) {
					$q = new WP_Query( array(
						'post_type'      => $post_type,
						'posts_per_page' => - 1,
					) );
				} else {
					$q = new WP_Query( array(
						'post_type'      => $post_type,
						'posts_per_page' => $posts_per_page,
						'paged'          => ci_get_page_var(),
					) );
				}
			?>

			<?php while ( $q->have_posts() ) : $q->the_post(); ?>

				<?php
					$cat_slugs = '';
					if ( 'on' == $isotope ) {
						$cats = wp_get_object_terms( get_the_ID(), $taxonomy );
						$cat_slugs = wp_list_pluck( $cats, 'slug' );
						$cat_slugs = implode( ' ', $cat_slugs );
					}

					$video_url  = get_post_meta( get_the_ID(), 'ci_cpt_videos_url', true );
					// TODO: Do we need this? Do we still support self-hosted videos?
					$video_type = get_post_meta( get_the_ID(), 'ci_cpt_videos_self', true );
				?>

				<li class="<?php echo esc_attr( $item_classes . ' ' . $cat_slugs ); ?>">
					<div class="list-item list-item-video">
						<a href="<?php echo esc_url( $video_url ); ?>" class="overlay-link ci-lightbox mfp-iframe">
							<?php the_post_thumbnail( $thumbnail_size ); ?>
							<div class="overlay icon-play"></div>
						</a>
						<div class="list-item-info">
							<h2 class="list-item-head"><?php the_title(); ?></h2>
						</div>
					</div>
				</li>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</ol>

		<?php ci_pagination( array(), $q ); ?>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
