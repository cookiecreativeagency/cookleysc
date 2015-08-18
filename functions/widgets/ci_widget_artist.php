<?php 
/**
 * Single Artist Widget.
 */
if( !class_exists('CI_Artist') ):
class CI_Artist extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'CI_Artist_widget', // Base ID
		    __( '-= CI Artist =-', 'ci_theme' ), // Name
			array( 'description' => __( 'Display a single artist', 'ci_theme' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$artist = intval( $instance['artist'] );
		
		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$artist = new WP_Query( array(
			'post_type' => 'cpt_artists',
			'p'         => $artist
		) );

		while ( $artist->have_posts() ) : $artist->the_post();
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

		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['artist'] = absint( $new_instance['artist'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'  => '',
			'artist' => ''
		) );
		extract( $instance );

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" class="widefat" /></p>';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'artist' ); ?>"><?php _e( 'Select Artist:', 'ci_theme' ); ?></label>
			<?php wp_dropdown_posts( array(
				'post_type' => 'cpt_artists',
				'selected'  => $artist
			), $this->get_field_name( 'artist' ) ); ?>
		</p>
		<?php 
	} // form

} // class CI_Artist

register_widget( 'CI_Artist' );

endif; // !class_exists
