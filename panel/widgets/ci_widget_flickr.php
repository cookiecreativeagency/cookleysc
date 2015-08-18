<?php
if( !class_exists('CI_Flickr') ):
class CI_Flickr extends WP_Widget {

	function CI_flickr() {
		$widget_ops = array( 'description' => __( 'FlickR Widget', 'ci_theme' ) );
		$control_ops = array(/*'width' => 200*/);
		parent::WP_Widget( 'ci_flickr_widget', __( '-= CI Flickr Widget =-', 'ci_theme' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$ci_title   = apply_filters( 'widget_title', empty( $instance['ci_title'] ) ? '' : $instance['ci_title'], $instance, $this->id_base );
		$ci_title = ci_get_string_translation('Flickr - Title', $ci_title, 'Widgets');

		$ci_id      = $instance['ci_id'];
		$ci_number  = $instance['ci_number'];
		$ci_type    = $instance['ci_type'];
		$ci_sorting = $instance['ci_sorting'];

		echo $before_widget;

		if ( $ci_title ) {
			echo $before_title . $ci_title . $after_title;
		}

		$url = sprintf( 'http://www.flickr.com/badge_code_v2.gne?count=%1$d&amp;display=%2$s&amp;&amp;layout=x&amp;source=%3$s&amp;%3$s=%4$s&amp;size=s',
			$ci_number,
			$ci_sorting,
			$ci_type,
			$ci_id
		);
		?><div class="f group"><script type="text/javascript" src="<?php echo esc_url( $url ); ?>"></script></div><?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['ci_title']   = sanitize_text_field( $new_instance['ci_title'] );
		$instance['ci_id']      = sanitize_text_field( $new_instance['ci_id'] );
		$instance['ci_number']  = absint( $new_instance['ci_number'] );
		$instance['ci_type']    = sanitize_key( $new_instance['ci_type'] );
		$instance['ci_sorting'] = sanitize_key( $new_instance['ci_sorting'] );

		$instance['ci_title'] = ci_register_string_translation( 'Flickr - Title', $instance['ci_title'], 'Widgets' );

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'ci_title'   => '',
			'ci_id'      => '',
			'ci_number'  => '',
			'ci_type'    => '',
			'ci_sorting' => '',
			'ci_size'    => ''
		) );
		$ci_title   = $instance['ci_title'];
		$ci_id      = $instance['ci_id'];
		$ci_number  = $instance['ci_number'];
		$ci_type    = $instance['ci_type'];
		$ci_sorting = $instance['ci_sorting'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_title' ) ); ?>"><?php _e( 'Title:', 'ci_theme' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'ci_title' ) ); ?>" value="<?php echo esc_attr( $ci_title ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ci_title' ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_id' ) ); ?>"><span style="color:#0063DC; font-weight:bold;">Flick<i style="font-style:normal;color:#FF0084">r</i></span> ID:</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'ci_id' ) ); ?>" value="<?php echo esc_attr( $ci_id ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ci_id' ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_type' ) ); ?>"><?php _e( 'Type:', 'ci_theme' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'ci_type' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ci_type' ) ); ?>">
				<option value="user" <?php selected( $ci_type, 'user' ); ?>><?php _e( 'User', 'ci_theme' ); ?></option>
				<option value="group" <?php selected( $ci_type, 'group' ); ?>><?php _e( 'Group', 'ci_theme' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_number' ) ); ?>"><?php _e( 'Number:', 'ci_theme' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'ci_number' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ci_number' ) ); ?>">
				<?php for ( $i = 1; $i <= 9; $i += 1 ): ?>
					<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $ci_number, $i ); ?>><?php echo esc_html( $i ); ?></option>
				<?php endfor; ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ci_sorting' ) ); ?>"><?php _e( 'Sorting:', 'ci_theme' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'ci_sorting' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ci_sorting' ) ); ?>">
				<option value="latest" <?php selected( $ci_sorting, 'latest' ); ?>><?php _e( 'Latest', 'ci_theme' ); ?></option>
				<option value="random" <?php selected( $ci_sorting, 'random' ); ?>><?php _e( 'Random', 'ci_theme' ); ?></option>
			</select>
		</p>
		<?php
	}
} 

register_widget('CI_Flickr');

endif; //class_exists
