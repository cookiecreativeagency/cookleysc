<?php get_header(); ?>

<?php get_template_part('inc_section'); ?>

<div class="row">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<?php
			$event_date     = get_post_meta( get_the_ID(), 'ci_cpt_events_date', true );
			$event_time     = get_post_meta( get_the_ID(), 'ci_cpt_events_time', true );
			$event_location = get_post_meta( get_the_ID(), 'ci_cpt_events_location', true );
			$event_venue    = get_post_meta( get_the_ID(), 'ci_cpt_events_venue', true );
			$event_status   = get_post_meta( get_the_ID(), 'ci_cpt_events_status', true );
			$event_wording  = get_post_meta( get_the_ID(), 'ci_cpt_events_button', true );
			$recurrent      = get_post_meta( get_the_ID(), 'ci_cpt_event_recurrent', true );
			$recurrence     = get_post_meta( get_the_ID(), 'ci_cpt_event_recurrence', true );
			$event_url      = '#';

			switch ( $event_status ) {
				case 'buy':
					if ($event_wording == '') $event_wording = __('Buy Tickets','ci_theme');
					$event_url = get_post_meta($post->ID, 'ci_cpt_events_tickets', true);
					break;
				case 'sold':
					if ($event_wording == '') $event_wording = __('Sold Out','ci_theme');
					break;
				case 'canceled':
					if ($event_wording == '') $event_wording = __('Canceled','ci_theme');
					break;
				case 'watch':
					if ($event_wording == '') $event_wording = __('Watch Live','ci_theme');
					$event_url = get_post_meta($post->ID, 'ci_cpt_events_live', true);
					break;
			}
		?>

		<article <?php post_class( 'group' ); ?>>

			<div class="col-md-4">
				
				<div class="post-cover">
					<a href="<?php echo ci_get_featured_image_src( 'large' ); ?>" class="overlay-link ci-lightbox">
						<?php the_post_thumbnail( 'ci_event' ); ?>
						<div class="overlay icon-zoom"></div>
					</a>
				</div>

			</div>

			<div class="col-md-8 content">

				<h2><?php the_title(); ?></h2>

				<?php $terms = get_the_term_list( get_the_ID(), 'event-category' ); ?>
				<?php if ( ! empty( $terms ) ) : ?>
					<p class="entry-terms"><?php echo $terms ?></p>
				<?php endif; ?>

				<div id="meta-wrap" class="group">

					<ul class="item-meta">
						<?php if ( $recurrent == 'enabled' ): ?>
							<li><span><?php _e( 'When:', 'ci_theme' ); ?></span><?php echo strip_tags( $recurrence ); ?></li>
						<?php else: ?>
							<?php if ($event_date != ''): ?><li><span><?php _e('Date:','ci_theme'); ?></span><?php echo $event_date; ?></li><?php endif; ?>
							<?php if ($event_time != ''): ?><li><span><?php _e('Time:','ci_theme'); ?></span><?php echo $event_time; ?></li><?php endif; ?>
						<?php endif; ?>
						<?php if ($event_location != ''): ?><li><span><?php _e('Location:','ci_theme'); ?></span><?php echo $event_location; ?></li><?php endif; ?>
						<?php if ($event_venue != ''): ?><li><span><?php _e('Venue:','ci_theme'); ?></span><?php echo $event_venue; ?></li><?php endif; ?>
						<?php if(!empty($event_status)): ?>
							<?php $new_window = in_array($event_status, array('buy', 'watch')) && ci_setting('events_url_buttons_new_win')=="enabled" ? ' target="_blank" ' : ''; ?>
							<li><span>&nbsp;</span><a href="<?php echo esc_url($event_url); ?>" class="action-btn <?php echo esc_attr($event_status); ?>" <?php echo $new_window; ?>><?php echo $event_wording; ?></a></li>
						<?php endif; ?>
					</ul>
					
				</div>

				<?php the_content(); ?>
				<?php wp_link_pages(); ?>

			</div>
			
		</article>

	<?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>
