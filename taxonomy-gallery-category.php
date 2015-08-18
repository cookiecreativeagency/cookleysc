<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<ol class="listing group">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php
				$gal_location = get_post_meta( get_the_ID(), 'ci_cpt_galleries_location', true );
				$gal_venue    = get_post_meta( get_the_ID(), 'ci_cpt_galleries_venue', true );
			?>
			<li class="col-md-4 col-sm-6">

				<div class="list-item">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
					<div class="list-item-info">
						<h2 class="list-item-head"><?php echo $gal_venue; ?></h2>
						<h3 class="list-item-sub"><?php echo $gal_location; ?></h3>
						<p class="album-actions">
							<a href="<?php the_permalink(); ?>" class="action-btn view"><?php _e( 'View set', 'ci_theme' ); ?></a>
						</p>
					</div>
				</div>

			</li>
		<?php endwhile; endif; ?>

	</ol>

</div>

<?php ci_pagination(); ?>

<?php get_footer(); ?>
