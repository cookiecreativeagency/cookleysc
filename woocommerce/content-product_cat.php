<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;


if ( $woocommerce_loop['columns'] == 1 ) {
	$col_class = 'col-md-12 col-xs-12';
} elseif ( $woocommerce_loop['columns'] == 2 ) {
	$col_class = 'col-md-6 col-xs-12';
} elseif ( $woocommerce_loop['columns'] == 3 ) {
	$col_class = 'col-md-4 col-sm-6 col-xs-12 item-narrow';
} elseif ( $woocommerce_loop['columns'] == 4 ) {
	$col_class = 'col-md-3 col-sm-6 col-xs-12 item-narrow';
} else {
	$col_class = 'col-md-4 col-sm-6 col-xs-12 item-narrow';
}

?>
<div class="<?php echo $col_class; ?> col-sm-6">

	<div class="product-category item">

		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

			<figure class="item-thumb">
				<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked woocommerce_subcategory_thumbnail - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
				</a>
			</figure>

			<div class="item-content">
				<div class="item-content-wrap">
					<div class="item-fold">
						<p class="item-title">
							<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
							<?php
								echo $category->name;

								if ( $category->count > 0 )
									echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
							?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="item-meta">
				<a class="item-more" href="<?php the_permalink(); ?>"><?php _e( 'View Category', 'ci_theme' ); ?></a>

			</div>


			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>

		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

	</div>

</div>