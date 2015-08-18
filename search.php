<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<?php
	global $wp_query;

	$found = $wp_query->found_posts;
	$none  = __( 'No results found. Please broaden your terms and search again.', 'ci_theme' );
	$one   = __( 'Just one result found. We either nailed it, or you might want to broaden your terms and search again.', 'ci_theme' );
	$many  = sprintf( _n( '%d result found.', '%d results found.', $found, 'ci_theme' ), $found );
?>

<div class="row">

	<div class="col-md-8 content">
		
		<article>
			
			<div class="post-body group">

				<p><?php ci_e_inflect( $found, $none, $one, $many ); ?></p>
				<?php
					if( $found==0 ) { 
						get_search_form();
					}
				?>

			</div>

		</article>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article <?php post_class( 'post' ); ?>>

				<div class="post-intro">

					<?php the_post_thumbnail( 'ci_post_thumbnail' ); ?>
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ci_theme' ), get_the_title() ) ); ?>"><?php the_title(); ?></a>
					</h2>

				</div>
				
				<div class="post-body group">

					<?php if ( is_singular( 'post' ) ) : ?>
						<p class="meta">
							<time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></time> 
							<span class="bull">&bull;</span> 
							<a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
						</p>
					<?php endif; ?>
					
					<?php ci_e_content(); ?>

				</div>

			</article>
										
		<?php endwhile; endif; ?>

		<?php ci_pagination(); ?>

	</div>

	<aside class="col-md-4 sidebar">

		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
		
	</aside>

</div>

<?php get_footer(); ?>
