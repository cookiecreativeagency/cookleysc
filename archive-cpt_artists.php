<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-md-12">

		<?php if ( ci_setting( 'artists_isotope' ) == 'enabled' ): ?>

			<ul class="filters-nav group">
				<li><a href="#filter" class="selected action-btn buy" data-filter="*"><?php _e( 'All Artists', 'ci_theme' ); ?></a></li>
				<?php $cats = get_terms( 'artist-category', array( 'hide_empty' => 1 ) ); ?>
				<?php foreach ( $cats as $cat ): ?>
					<li><a href="#filter" data-filter=".<?php echo esc_attr( $cat->slug ); ?>" class="action-btn buy"><?php echo $cat->name; ?></a></li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>
	
	</div>
	
</div>

<div class="row">

	<ol class="listing group <?php if ( ci_setting( 'artists_isotope' ) == 'enabled' ): ?> filter-container filter-container-artists <?php endif; ?>">

		<?php
			if ( ci_setting( 'artists_isotope' ) == 'enabled' ) {
				query_posts( array(
					'post_type'      => 'cpt_artists',
					'posts_per_page' => - 1
				) );
			} else {
				query_posts( array(
					'post_type'      => 'cpt_artists',
					'posts_per_page' => ci_setting( 'artists_per_page' ),
					'paged'          => ci_get_page_var(),
				) );
			}
		?>

		<?php if ( have_posts() ) : while ( have_posts() ) :the_post(); ?>

			<?php
				$cat_slugs = '';
				if ( ci_setting( 'artists_isotope' ) == 'enabled' ) {
					$cats = wp_get_object_terms( get_the_ID(), 'artist-category' );
					$cat_slugs = wp_list_pluck( $cats, 'slug' );
					$cat_slugs = implode( ' ', $cat_slugs );
				}
			?>

			<li class="col-md-4 col-sm-6 <?php echo esc_attr( $cat_slugs ); ?>">
				<div class="list-item">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
					<div class="list-item-info">
						<h2 class="list-item-head"><?php the_title(); ?></h2>
						<p class="list-item-actions">
							<a href="<?php the_permalink(); ?>" class="action-btn buy"><?php _e( 'Learn more', 'ci_theme' ); ?></a>
						</p>
					</div>
				</div>
			</li>

		<?php endwhile; endif; ?>
		
	</ol>
</div>

<?php ci_pagination(); ?>
<?php wp_reset_query(); ?>

<?php get_footer(); ?>
