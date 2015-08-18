<?php 
/**
 * Artists listing Widget.
 */
if( !class_exists('CI_Artists') ):
class CI_Artists extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'ci_artists_widget', // Base ID
		    __( '-= CI Artists =-', 'ci_theme' ), // Name
			array( 'description' => __( 'Displays a list of artists.', 'ci_theme' ), )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$artists_no   = $instance['artists_no'];
		$artists_rand = $instance['artists_rand'];

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$args = array(
			'post_type'      => 'cpt_artists',
			'posts_per_page' => $artists_no
		);

		if ( 'on' == $artists_rand ) {
			$args['orderby'] = 'rand';
		}

		$artists = new WP_Query( $args );

		while ( $artists->have_posts() ) : $artists->the_post();
			?>
			<div class="list-item">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
				<div class="list-item-info">
					<h2 class="list-item-head"><?php the_title(); ?></h2>
					<h3 class="list-item-sub"><?php the_terms( get_the_ID(), 'artist-category'); ?></h3>
					<p class="list-item-actions">
						<a href="<?php the_permalink(); ?>" class="action-btn view"><?php _e( 'View artist', 'ci_theme' ); ?></a>
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

		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['artists_no']   = absint( $new_instance['artists_no'] );
		$instance['artists_rand'] = ci_sanitize_checkbox( $new_instance['artists_rand'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'        => '',
			'artists_no'   => 3,
			'artists_rand' => ''
		) );
		extract( $instance );

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" class="widefat" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'artists_no' ) . '">' . __( 'Artists number:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'artists_no' ) . '" name="' . $this->get_field_name( 'artists_no' ) . '" type="text" value="' . esc_attr( $artists_no ) . '" class="widefat" /></p>';

		?>
		<p>
			<input id="<?php echo $this->get_field_id( 'artists_rand' ); ?>" name="<?php echo $this->get_field_name( 'artists_rand' ); ?>" type="checkbox" class="checkbox" <?php checked( $instance['artists_rand'], 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'artists_rand' ); ?>"><?php _e( 'Random order.', 'ci_theme' ); ?></label>
		</p>
		<?php 
	} // form

} // class CI_Artists

register_widget( 'CI_Artists' );

endif; // !class_exists
