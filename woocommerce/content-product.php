<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array( 'list-item' );

if ( $woocommerce_loop['columns'] == 1 ) {
	$col_class = 'col-md-12 col-xs-12';
} elseif ( $woocommerce_loop['columns'] == 2 ) {
	$col_class = 'col-md-6 col-sm-6 col-xs-12';
} elseif ( $woocommerce_loop['columns'] == 3 ) {
	$col_class = 'col-lg-4 col-sm-6 col-xs-12';
} elseif ( $woocommerce_loop['columns'] == 4 ) {
	$col_class = 'col-lg-3 col-md-6 col-sm-6 col-xs-12';
} else {
	$col_class = 'col-md-4 col-sm-6 col-xs-12';
}

?>

<div class="<?php echo $col_class; ?>">

	<div <?php post_class( $classes ); ?>>

		<?php
			/**
			 * woocommerce_before_shop_loop_item hook
			 */
			do_action( 'woocommerce_before_shop_loop_item' );
		?>

			<a class="item-thumb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>

			<div class="list-item-info">
				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5 // REMOVED by the theme
					 * @hooked woocommerce_template_loop_price - 10 // REMOVED by the theme
					 */

					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
				<p class="list-item-sub"><?php echo get_the_term_list($post->ID, 'product_cat', '', ', ', ''); ?></p>

				<p class="list-item-head"><?php the_title(); ?></p>

				<p class="list-item-actions"><a class="action-btn buy" href="<?php the_permalink(); ?>"><?php _e( 'Learn More', 'ci_theme' ); ?></a></p>
			</div>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

	</div>

</div>
