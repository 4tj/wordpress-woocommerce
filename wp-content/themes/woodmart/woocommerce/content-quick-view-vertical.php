<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$product = wc_get_product( $post );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

$classes = array();
$classes[] = 'product-quick-view single-product-content quick-view-vertical';

woodmart_set_loop_prop( 'is_quick_view', 'quick-view' );

/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

if ( function_exists( 'woodmart_quick_view_vg_data' ) ) {
	woodmart_quick_view_vg_data(true);
}

$product_summary_class = '';

if ( is_rtl() ) {
	$product_summary_class .= ' text-right';
} else {
	$product_summary_class .= ' text-left';
}

?>

<div id="product-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<div class="wd-grid-g product-image-summary">
		<div class="product-images woocommerce-product-gallery">
			<?php woodmart_product_images_slider(); ?>
		</div>
		<div class="summary entry-summary wd-scroll<?php echo esc_attr( $product_summary_class ); ?>">
			<div class="summary-inner wd-set-mb reset-last-child wd-scroll-content">
				<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_loop_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>
	</div>


</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
