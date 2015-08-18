<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<ol class="listing group">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li class="col-md-4 col-sm-6">

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

	<?php ci_pagination(); ?>

</div>

<?php get_footer(); ?>
