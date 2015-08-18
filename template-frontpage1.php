<?php
/*
Template Name: Homepage (Sidebar #1 / Content / Sidebar #2)
*/
?>
<?php get_header(); ?>

<?php get_template_part( 'inc_slider' ); ?>

<?php get_template_part( 'inc_hero_player' ); ?>

<div class="row">

	<div class="col-md-6 col-md-push-3 content">
		<?php if ( ci_setting( 'homepage-page-id' ) == "" ): ?>

			<h3 class="widget-title"><?php _e( 'News', 'ci_theme' ); ?></h3>
			<?php
				$q = new WP_Query( array(
					'post_type'      => 'post',
					'paged'          => ci_get_page_var(),
					'posts_per_page' => ci_setting( 'news-no' ),
					'cat'            => ci_setting( 'news-cat' )
				) );
			?>
			<?php while ( $q->have_posts() ) : $q->the_post(); ?>

				<article class="post group">

					<div class="post-intro">
						<?php
							if ( ci_setting( 'featured_single_show' ) == 'enabled' ) {
								the_post_thumbnail( 'ci_post_thumbnail' );
							}
						?>
						<h2>
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ci_theme' ), get_the_title() ) ); ?>"><?php the_title(); ?></a>
						</h2>
					</div>

					<div class="post-body">
						<p class="meta">
							<time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></time>
							<span class="bull">&bull;</span> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
							<span class="bull">&bull;</span><?php the_category(' '); ?>
						</p>
						<?php the_excerpt(); ?>
					</div>

				</article>

			<?php endwhile; ?>

			<?php ci_pagination( array(), $q ); ?>
			<?php wp_reset_postdata(); ?>

		<?php else: ?>

			<?php
				$the_page = new WP_Query( array(
					'page_id' => ci_setting( 'homepage-page-id' )
				) );
			?>
			<?php while ( $the_page->have_posts() ) : $the_page->the_post(); ?>

				<h3 class="widget-title"><?php the_title(); ?></h3>

				<article class="post group">

					<div class="post-intro">
						<?php
							if ( ci_setting( 'featured_single_show' ) == 'enabled' ) {
								the_post_thumbnail();
							}
						?>
					</div>

					<div class="post-body">
						<?php the_content(); ?>
					</div>

				</article>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</div>

	<aside class="col-md-3 col-md-pull-6 sidebar">

		<?php dynamic_sidebar( 'homepage-sidebar-one' ); ?>
		
	</aside>



	<aside class="col-md-3 sidebar">

		<?php dynamic_sidebar( 'homepage-sidebar-two' ); ?>

	</aside>

</div>

<?php get_footer(); ?>
