<?php

// Let WooCommerce know that we support it.
add_theme_support( 'woocommerce' );

// Set image sizes also for woocommerce.
// Run only when the theme or WooCommerce is activated.
add_action( 'ci_theme_activated', 'ci_woocommerce_image_dimensions' );
register_activation_hook( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php', 'ci_woocommerce_image_dimensions' );
if ( ! function_exists( 'ci_woocommerce_image_dimensions' ) ):
function ci_woocommerce_image_dimensions() {
	// Image sizes
	// crop: If not set at all, means resize. Any other value means crop.
	update_option( 'shop_thumbnail_image_size', array(
		'width'  => '100',
		'height' => '100',
		'crop'   => 1
	) );
	update_option( 'shop_catalog_image_size', array(
		'width'  => '500',
		'height' => '500',
		'crop'   => 1
	) );
	update_option( 'shop_single_image_size', array(
		'width'  => '500',
		'height' => '0',
	) );
}
endif;



if ( woocommerce_enabled() ):

	// Skip the default woocommerce styling and use our boilerplate.
	add_filter( 'woocommerce_enqueue_styles', 'ci_deregister_woocommerce_styles' );
	if ( !function_exists( 'ci_deregister_woocommerce_styles' ) ):
	function ci_deregister_woocommerce_styles() {
		wp_deregister_style( 'woocommerce-general' );
	}
	endif;

	// Change number of columns in product loop
	add_filter( 'loop_shop_columns', 'ci_loop_show_columns' );
	if ( !function_exists( 'ci_loop_show_columns' ) ):
	function ci_loop_show_columns() {
		return ci_setting( 'product_columns' );
	}
	endif;

	// Set the number of cross sells product count and columns (in cart page) to the same number as the shop columns.
	// Related and Upsells are set to the same number directly from their respective template files.
	add_filter( 'woocommerce_cross_sells_total', 'ci_woocommerce_cross_sells_columns' );
	add_filter( 'woocommerce_cross_sells_columns', 'ci_woocommerce_cross_sells_columns' );
	if ( !function_exists( 'ci_woocommerce_cross_sells_columns' ) ):
	function ci_woocommerce_cross_sells_columns( $posts_per_page ) {
		return 2;
	}
	endif;

	// Remove result count, e.g. "Showing 1–10 of 22 results", added manually
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	add_action( 'woocommerce_before_shop_loop', 'ci_woocommerce_shop_actions', 20 );
	if ( !function_exists( 'ci_woocommerce_shop_actions' ) ):
	function ci_woocommerce_shop_actions() {
		?>
		<div class="actions">

			<?php woocommerce_result_count(); ?>

			<div class="product-number">
				<span><?php _e( 'View:', 'ci_theme' ); ?></span>
				<a href="<?php echo esc_url( add_query_arg('view', ci_setting('eshop_products_view_first'), get_permalink( ci_translate_post_id( wc_get_page_id( 'shop' ), true, 'page' ) ) ) ); ?>"><?php ci_e_setting('eshop_products_view_first'); ?></a>
				<a href="<?php echo esc_url( add_query_arg('view', ci_setting('eshop_products_view_second'), get_permalink( ci_translate_post_id( wc_get_page_id( 'shop' ), true, 'page' ) ) ) ); ?>"><?php ci_e_setting('eshop_products_view_second'); ?></a>
				<?php if ( ci_setting('eshop_products_view_all') ) : ?>
					<a href="<?php echo esc_url( add_query_arg('view', 'all', get_permalink( ci_translate_post_id( wc_get_page_id( 'shop' ), true, 'page' ) ) ) ); ?>"><?php _e('All', 'ci_theme'); ?></a>
				<?php endif; ?>
			</div>

		</div><!-- .actions -->
		<?php
	}
	endif;

	// Break upsells and related products out of the product wrapper.
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	// Related products
	if ( ci_setting( 'eshop_single_related_show' ) == 'on' ) {
		add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 );
	}
	// Upsell products
	if ( ci_setting( 'eshop_single_up_sells_show' ) == 'on' ) {
		add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 );
	}



	// We don't need the Rating and Add to Cart button in the listing.
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	// We don't need the coupon form in the checkout page. It's included in the cart page.
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

	// Remove breadcrumbs.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

	// Move meta above the title.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 3 );

	// Remove star rating.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );


	// Move cross sell display from collaterals to right after the table.
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );


	// Add an overlay (zoom icon) in single product images and thumbs.
	add_filter( 'woocommerce_single_product_image_html', 'ci_woocommerce_single_product_image_html', 10 );
	add_filter( 'woocommerce_single_product_image_thumbnail_html', 'ci_woocommerce_single_product_image_html', 10 );
	if ( !function_exists( 'ci_woocommerce_single_product_image_html' ) ):
	function ci_woocommerce_single_product_image_html( $html ) {
		$html = str_replace( '</a>', '<span class="img-overlay"></span></a>', $html );

		return $html;
	}
	endif;

	// Replace the default placeholder image with ours (it has the right dimensions).
	add_filter( 'woocommerce_placeholder_img_src', 'ci_change_woocommerce_placeholder_img_src' );
	if ( !function_exists( 'ci_change_woocommerce_placeholder_img_src' ) ):
	function ci_change_woocommerce_placeholder_img_src( $src ) {
		return get_child_or_parent_file_uri( '/images/placeholder.png' );
	}
	endif;

	// Remove width and height from the placeholder image.
	add_filter( 'woocommerce_placeholder_img', 'ci_woocommerce_placeholder_img' );
	if ( !function_exists( 'ci_woocommerce_placeholder_img' ) ):
	function ci_woocommerce_placeholder_img( $html ) {
		$html = preg_replace( '/width="[[:alnum:]%]*"/', '', $html );
		$html = preg_replace( '/height="[[:alnum:]%]*"/', '', $html );

		return $html;
	}
	endif;


	// Make some WooCommerce pages get the fullwidth template
	add_filter( 'template_include', 'ci_theme_wc_cart_fullwidth' );
	if ( ! function_exists( 'ci_theme_wc_cart_fullwidth' ) ):
	function ci_theme_wc_cart_fullwidth( $template ) {
		$located = get_child_or_parent_file_path( 'template-fullwidth.php' );

		if( woocommerce_enabled() and !empty( $located ) ) {
			if( is_cart() || is_checkout() || is_account_page() ) {
				return $located;
			}
		}

		return $template;
	}
	endif;

endif; // woocommerce_enabled()
