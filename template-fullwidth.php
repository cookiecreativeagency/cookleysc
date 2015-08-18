<?php
/*
Template Name: Fullwidth
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-xs-12">

		<article class="post static">

			<div class="post-body group">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="post-intro">
						<?php if ( ci_setting( 'featured_single_show' ) == 'enabled' ) {
							the_post_thumbnail( 'ci_fullwidth' );
						} ?>
					</div>

					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
					<?php comments_template(); ?>
				<?php endwhile; endif; ?>
			</div>

		</article>	

	</div>

</div>

<?php get_footer(); ?>
