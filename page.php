<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-md-8 content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article <?php post_class( 'static' ); ?>>

				<div class="post-body ">

					<?php the_post_thumbnail( 'ci_post_thumbnail' ); ?>
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>

				</div>

				<?php comments_template(); ?>

			</article>

		<?php endwhile; endif; ?>

	</div>

	<aside class="col-md-4 sidebar">

		<?php dynamic_sidebar( 'pages-sidebar' ); ?>

	</aside>
</div>

<?php get_footer(); ?>