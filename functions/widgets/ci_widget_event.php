<?php 
/**
 * An  Widgets.
 */
if( !class_exists('CI_Event') ):

class CI_Event extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'CI_Event_widget', // Base ID
		    __( '-= CI Event =-', 'ci_theme' ), // Name
			array( 'description' => __( 'Display a single event', 'ci_theme' ), ),
			array( /* 'width' => 300, 'height' => 400 */ )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$event = $instance['event'];

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$event = new WP_Query( array(
			'post_type' => 'cpt_events',
			'p'         => $event
		) );

		$event_new_win = ci_setting( 'events_new_win' ) == '' ? '' : ' target="_blank" ';

		echo '<ul class="tour-event">';
		while ( $event->have_posts() ) : $event->the_post();
			global $post;

			$event_date     = explode( '-', get_post_meta( get_the_ID(), 'ci_cpt_events_date', true ) );
			$event_time     = get_post_meta( get_the_ID(), 'ci_cpt_events_time', true );
			$event_location = get_post_meta( get_the_ID(), 'ci_cpt_events_location', true );
			$event_venue    = get_post_meta( get_the_ID(), 'ci_cpt_events_venue', true );
			$event_status   = get_post_meta( get_the_ID(), 'ci_cpt_events_status', true );
			$event_wording  = get_post_meta( get_the_ID(), 'ci_cpt_events_button', true );
			$recurrent      = get_post_meta( get_the_ID(), 'ci_cpt_event_recurrent', true );
			$recurrence     = get_post_meta( get_the_ID(), 'ci_cpt_event_recurrence', true );
			$event_url      = '#';

			switch ($event_status) {
				case 'buy':
					if ($event_wording == '') $event_wording 	= __('Buy Tickets','ci_theme'); 
					$event_url		= get_post_meta(get_the_ID(), 'ci_cpt_events_tickets', true);
					break;
				case 'sold':
					if ($event_wording == '') $event_wording 	= __('Sold Out','ci_theme'); 
					break;
				case 'canceled':
					if ($event_wording == '') $event_wording 	= __('Canceled','ci_theme'); 
					break;
				case 'watch':
					if ($event_wording == '') $event_wording 	= __('Watch Live','ci_theme');
					$event_url		= get_post_meta(get_the_ID(), 'ci_cpt_events_live', true);
					break; 
			}

			?>
			<li class="group">
				<p class="tour-event-thumb"><a href="<?php the_permalink(); ?>" <?php echo $event_new_win; ?>><?php the_post_thumbnail( 'ci_event' ); ?></a></p>

				<div class="tour-group group">
					<?php if ( $recurrent == 'enabled' ): ?>
						<p class="tour-date"><?php echo $recurrence; ?></p>
					<?php else: ?>
						<p class="tour-date"><span class="day"><?php echo $event_date[2]; ?></span><?php echo ci_the_month( $event_date[1] ); ?> <span class="year"><?php echo $event_date[0]; ?></span></p>
					<?php endif; ?>
					<div class="tour-place">
						<span class="sub-head"><?php if ($post->post_content != ''): ?><a href="<?php the_permalink(); ?>" <?php echo $event_new_win; ?>><?php endif; ?><?php the_title(); ?><?php if ($post->post_content != ''): ?></a><?php endif; ?></span>
						<span class="main-head"><?php echo $event_venue; ?></span>
						<?php if ( ! empty( $event_status ) ): ?>
							<?php $new_window = in_array( $event_status, array( 'buy', 'watch' ) ) && ci_setting( 'events_url_buttons_new_win' ) == 'enabled' ? ' target="_blank" ' : ''; ?>
							<a href="<?php echo esc_url( $event_url ); ?>" class="action-btn <?php echo esc_attr( $event_status ); ?>" <?php echo $new_window; ?>><?php echo $event_wording; ?></a>
						<?php endif; ?>
					</div>
				</div>
			</li>
			<?php
		endwhile;
		wp_reset_postdata();
		echo '</ul>';

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['event'] = intval( $new_instance['event'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'event' => ''
		) );

		$title = htmlspecialchars( $instance['title'] );
		$event = intval( $instance['event'] );

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'ci_theme' ) . '</label><input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" class="widefat" /></p>';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'event' ); ?>"><?php _e( 'Select event:', 'ci_theme' ); ?></label>
			<?php wp_dropdown_posts( array(
				'post_type' => 'cpt_events',
				'selected'  => $event
			), $this->get_field_name( 'event' ) ); ?>
		</p>
				
		<?php 
	} // form

} // class CI_Event

register_widget( 'CI_Event' );

endif; // !class_exists
