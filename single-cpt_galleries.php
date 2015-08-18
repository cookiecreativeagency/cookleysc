<?php get_header(); ?>

<?php get_template_part('inc_section'); ?>

<div class="row">

	<ol class="listing group">
		<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				$captions = get_post_meta( get_the_ID(), 'ci_cpt_galleries_caption', true );

				$attachments = ci_featgal_get_attachments();

				while ( $attachments->have_posts() ) {
					$attachments->the_post();
					$attr = array(
						'alt'   => trim( strip_tags( get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true ) ) ),
						'title' => trim( strip_tags( get_the_title() ) )
					);

					$img_attrf = wp_get_attachment_image_src( get_the_ID(), 'large' );

					echo '<li class="col-md-4 col-sm-6"><div class="list-item">';
					echo '<a href="' . esc_url( $img_attrf[0] ) . '" class="overlay-link ci-lightbox">' . wp_get_attachment_image( get_the_ID(), 'post-thumbnail', false, $attr ) . '<div class="overlay icon-zoom"></div></a>';

					if ( $captions == 1 ):
						echo '<div class="list-item-info"><h2 class="list-item-head">';
						echo get_the_title();
						echo '</h2></div>';
					endif;

					echo '</div></li>';
				}
			endwhile; endif;
		?>
	</ol>

	<?php ci_pagination(); ?>

</div>

<?php get_footer(); ?>
