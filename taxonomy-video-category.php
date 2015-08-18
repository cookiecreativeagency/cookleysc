<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">
		
	<ol class="listing group">		

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php
				$video_url  = get_post_meta( get_the_ID(), 'ci_cpt_videos_url', true );
				$video_type = get_post_meta( get_the_ID(), 'ci_cpt_videos_self', true );
			?>	

			<li class="col-md-4 col-sm-6">

				<div class="list-item list-item-video">
					<a href="<?php echo esc_url( $video_url ); ?>" class="overlay-link ci-lightbox mfp-iframe">
						<?php the_post_thumbnail(); ?>
						<div class="overlay icon-play"></div>
					</a>

					<div class="list-item-info">
						<h2 class="list-item-head"><?php the_title(); ?></h2>
					</div>
				</div>

			</li>

		<?php endwhile; endif; ?>

	</ol>
</div>

<?php ci_pagination(); ?>

<?php get_footer(); ?>
