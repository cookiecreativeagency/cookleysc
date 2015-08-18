<?php get_header(); ?>

<?php get_template_part( 'inc_section' ); ?>

<div class="row">

	<div class="col-md-12 item">
	
		<p><?php _e( 'Oh, no! Test The page you requested could not be found. Perhaps searching will help...', 'ci_theme' ); ?></p>

		<form role="search" method="get" id="search-body" action="<?php echo esc_url(home_url('/')); ?>">
			<div>
				<input type="text" name="s" id="s-body" value="<?php echo( get_search_query() != "" ? get_search_query() : __( 'Search', 'ci_theme' ) ); ?>" size="18" onfocus="if (this.value == '<?php _e( 'Search', 'ci_theme' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Search', 'ci_theme' ); ?>';}"/>
				<input type="submit" id="searchsubmit-body" value="<?php _e( 'Search', 'ci_theme' ); ?>"/>
			</div>
		</form>				

		<script type="text/javascript">
			// focus on search field after it has loaded
			document.getElementById('s-body') && document.getElementById('s-body').focus();
		</script>		

	</div>

</div>

<?php get_footer(); ?>