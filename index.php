<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-md-8 content">
	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<article <?php post_class(); ?>>

				<div class="post-intro">

					<?php the_post_thumbnail( 'ci_post_thumbnail' ); ?>
					
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ci_theme' ), get_the_title() ) ); ?>">
							<?php the_title(); ?>
						</a>
					</h2>

				</div>
			
				<div class="post-body group">
					
					<p class="meta">
						<time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></time>
							<span class="bull">&bull;</span><?php the_category(' '); ?>
					</p>
					
					<?php ci_e_content(); ?>

				</div>

			</article>
										
		<?php endwhile; endif; ?>

		<?php ci_pagination(); ?>

	</div>

	<aside class="col-md-4 sidebar">

		<?php dynamic_sidebar('blog-sidebar'); ?>

	</aside>

</div>

<?php get_footer(); ?>
