<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">	

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
			// Album Details
			$album_date   = get_post_meta( get_the_ID(), 'ci_cpt_discography_date', true );
			$album_label  = get_post_meta( get_the_ID(), 'ci_cpt_discography_label', true );
			$album_cat_no = get_post_meta( get_the_ID(), 'ci_cpt_discography_cat_no', true );

			// Purchase Details
			$album_status     = get_post_meta( get_the_ID(), 'ci_cpt_discography_status', true );
			$album_text       = get_post_meta( get_the_ID(), 'ci_cpt_discography_purchase_text', true );
			$album_text_from1 = get_post_meta( get_the_ID(), 'ci_cpt_discography_purchase_text_from1', true );
			$album_text_url1  = get_post_meta( get_the_ID(), 'ci_cpt_discography_purchase_text_url1', true );
			$album_text_from2 = get_post_meta( get_the_ID(), 'ci_cpt_discography_purchase_text_from2', true );
			$album_text_url2  = get_post_meta( get_the_ID(), 'ci_cpt_discography_purchase_text_url2', true );
		?>

		<article <?php post_class( 'group' ); ?>>

			<div class="col-md-4 col-sm-4">

				<div class="list-item">
					<a href="<?php echo esc_attr( ci_get_featured_image_src( 'large' ) ); ?>" class="overlay-link ci-lightbox">
						<?php the_post_thumbnail( 'ci_discography' ); ?>
						<div class="overlay icon-zoom"></div>
					</a>

					<div class="list-item-info">
						<h2 class="list-item-head"><?php echo $album_status; ?></h2>
						<h3 class="list-item-sub"><?php echo $album_text; ?></h3>
						<p class="list-item-actions">
							<?php if ( ! empty( $album_text_from1 ) ): ?>
								<a href="<?php echo $album_text_url1; ?>" class="action-btn buy"><?php echo $album_text_from1; ?></a>
							<?php endif; ?>
							<?php if ( ! empty( $album_text_from2 ) ): ?>
								<a href="<?php echo $album_text_url2; ?>" class="action-btn buy"><?php echo $album_text_from2; ?></a>
							<?php endif; ?>
						</p>
					</div>

				</div>

				<div id="single-sidebar" class="sidebar">

					<?php dynamic_sidebar( 'album-sidebar' ); ?>

				</div>

			</div>

			<div class="col-md-8 col-sm-8 content group">

				<h2><?php the_title(); ?></h2>
				<?php $terms = get_the_term_list( get_the_ID(), 'section', '', ', ' ); ?>

				<?php if ( ! empty( $terms ) ) : ?>
					<p class="entry-terms"><?php echo $terms ?></p>
				<?php endif; ?>

				<div id="meta-wrap" class="group">
					<ul class="item-meta">
						<?php if ( ! empty( $album_date ) ): ?><li><span><?php _e( 'Event date:', 'ci_theme' ); ?></span> <?php echo $album_date; ?></li><?php endif; ?>
						<?php if ( ! empty( $album_label ) ): ?><li><span><?php _e( 'Location:', 'ci_theme' ); ?></span> <?php echo $album_label; ?></li><?php endif; ?>
						<?php if ( ! empty( $album_cat_no ) ): ?><li><span><?php _e( 'Cost:', 'ci_theme' ); ?></span> <?php echo $album_cat_no; ?></li><?php endif; ?>
					</ul>
				</div>

				<?php the_content(); ?>
				<?php wp_link_pages(); ?>

			</div>

		</article>
	
	<?php endwhile; endif; ?>
		
</div>

<?php get_footer(); ?>
