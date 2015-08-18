<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<ol class="listing group">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php $album_date = explode( '-', get_post_meta( get_the_ID(), 'ci_cpt_discography_date', true ) ); ?>

			<li class="col-md-4">
				
				<div class="list-item">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'ci_discography' ); ?>
					</a>
					<div class="list-item-info">
						<h2 class="list-item-head"><?php _e( 'Release date:', 'ci_theme' ); ?> <?php echo $album_date[2]; ?>-<?php echo ci_the_month( $album_date[1] ); ?>-<?php echo $album_date[0]; ?></h2>
						<h3 class="list-item-sub"><?php the_title(); ?></h3>
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

<?php get_footer(); ?>
