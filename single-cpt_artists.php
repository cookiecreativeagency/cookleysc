<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class( 'album group' ); ?>>
		
			<div class="col-sm-4">

				<div class="post-cover">
					<a href="<?php echo esc_url( ci_get_featured_image_src( 'large' ) ); ?>" class="overlay-link ci-lightbox">
						<?php the_post_thumbnail(); ?>
						<div class="overlay icon-zoom"></div>
					</a>
				</div>

				<div id="single-sidebar" class="sidebar">

					<?php dynamic_sidebar( 'artist-sidebar' ); ?>
					
				</div>		

			</div>
			
			<div class="col-sm-8 content group">

				<h2><?php the_title(); ?></h2>

				<?php $terms = get_the_term_list( get_the_ID(), 'artist-category', '', ', ' ); ?>
				<?php if ( ! empty( $terms ) ) : ?>
					<p class="entry-terms"><?php echo $terms ?></p>
				<?php endif; ?>

				<?php the_content(); ?>
				<?php wp_link_pages(); ?>

			</div>			
		
		</article>
	
	<?php endwhile; endif; ?>
		
</div>

<?php get_footer(); ?>
