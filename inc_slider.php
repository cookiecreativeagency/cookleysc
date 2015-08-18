<?php if ( ci_setting( 'slider_show' ) == 'enabled' ) : ?>
	<?php
		$slider     = ci_theme_get_slides( false, get_queried_object_id(), false, ci_setting( 'slider-no' ) );
		$attributes = sprintf( 'data-animation="%s" data-direction="%s" data-slideshow="%s" data-slideshowspeed="%s" data-animationspeed="%s"',
			esc_attr( ci_setting( 'slider_effect' ) ),
			esc_attr( ci_setting( 'slider_direction' ) ),
			esc_attr( ci_setting( 'slider_autoslide' ) == 'enabled' ? '1' : '0' ),
			esc_attr( (string) ci_setting( 'slider_speed' ) ),
			esc_attr( (string) ci_setting( 'slider_duration' ) )
		);
	?>
	<?php if( $slider->have_posts() ): ?>
		<div id="slider" class="row">
			<div class="col-md-12">
				<div class="home-slider ci-slider loading" <?php echo $attributes; ?>>
					<ul class="slides">

						<?php while ( $slider->have_posts() ) : $slider->the_post(); ?>
							<?php
								$img_url      = ci_get_featured_image_src( 'ci_fullwidth' );
								$slider_text  = get_post_meta( get_the_ID(), 'ci_cpt_slider_text', true );
								$slider_video = get_post_meta( get_the_ID(), 'ci_cpt_slider_video', true );
								$slider_link  = get_post_meta( get_the_ID(), 'ci_cpt_slider_url', true );
							?>
							<?php if ( ! empty( $img_url ) ): ?>
								<li>
									<?php if ( ! empty( $slider_link ) ): ?>
										<a href="<?php echo $slider_link; ?>">
									<?php endif; ?>

									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" />

									<?php if ( $slider_text != 1 ): ?>
										<div class="slide-text">
											<h2><?php the_title(); ?></h2>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $slider_link ) ): ?>
										</a>
									<?php endif; ?>
								</li>
							<?php else: ?>
								<li class="video-slide">
									<?php echo wp_oembed_get( $slider_video ); ?>
								</li>
							<?php endif; ?>

						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>

					</ul>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
