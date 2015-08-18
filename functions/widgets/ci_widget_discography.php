<?php 
/**
 * Recent discography Widgets.
 */
if( !class_exists('CI_Discography') ):

class CI_Discography extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
	 		'ci_discography_widget', // Base ID
		    __( '-= CI Latest Albums =-', 'ci_theme' ), // Name
			array( 'description' => __( 'Display your latest albums', 'ci_theme' ) ),
			array( /* 'width' => 300, 'height' => 400 */ )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$disc_no = $instance['disc_no'];

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$latest_discography = new WP_Query( array(
			'post_type'      => 'cpt_discography',
			'posts_per_page' => $disc_no
		) );

		while ( $latest_discography->have_posts() ) : $latest_discography->the_post();

			$album_date = explode( '-', get_post_meta( get_the_ID(), 'ci_cpt_discography_date', true ) );

			?>
			<div class="list-item">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'ci_discography' ); ?>
				</a>
				<div class="list-item-info">
					<h2 class="list-item-head"><?php the_title(); ?></h2>
					<p class="list-item-actions">
						<a href="<?php the_permalink(); ?>" class="action-btn buy"><?php _e( 'Learn more', 'ci_theme' ); ?></a>
					</p>
				</div>	
			</div>
			<?php

		endwhile;
		wp_reset_postdata();

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']   = sanitize_text_field( $new_instance['title'] );
		$instance['disc_no'] = absint( $new_instance['disc_no'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'   => '',
			'disc_no' => 3
		) );

		$title   = $instance['title'];
		$disc_no = $instance['disc_no'];

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" class="widefat" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'disc_no' ) . '">' . __( 'Albums Number:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'disc_no' ) . '" name="' . $this->get_field_name( 'disc_no' ) . '" type="text" value="' . esc_attr( $disc_no ) . '" class="widefat" /></p>';
	} // form

} // class CI_discography

register_widget( 'CI_Discography' );

endif; // !class_exists
