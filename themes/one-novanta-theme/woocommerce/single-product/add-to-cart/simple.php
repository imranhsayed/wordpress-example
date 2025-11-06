<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

use OneNovanta\Controllers\Common\Template;

global $product;

// Bail out if the product is not purchasable.
if ( ! $product->is_purchasable() ) {
	return;
}

// Get SKU.
$sku = $product->get_sku();

// Get speak to our experts URL.
$speak_to_our_experts_url = one_novanta_get_speak_our_expert_url();

one_novanta_kses_post_e( wc_get_stock_html( $product ) ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="variations_form cart is_simple" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

		<div class="woocommerce-variation single_variation" role="alert" aria-relevant="additions"></div>

		<div class="wp-block-woocommerce-product-meta">
			<div class="product-details__meta sku">
				<span class="wp-block-post-terms__prefix"><?php esc_html_e( 'Model Number: ', 'one-novanta-theme' ); ?></span>
				<span class="sku"><?php echo $sku ? esc_html( $sku ) : esc_html__( 'N/A', 'one-novanta-theme' ); ?></span>
			</div>
		</div>

		<div class="woocommerce-add-to-cart-buttons">
			<?php
			if ( ! empty( $speak_to_our_experts_url ) ) {
				Template::render_component(
					'button',
					null,
					[
						'content' => __( 'Speak to our experts', 'one-novanta-theme' ),
						'url'     => $speak_to_our_experts_url,
						'icon'    => true,
						'variant' => 'secondary',
					],
				);
			}

			do_action( 'woocommerce_before_add_to_cart_button' );

			Template::render_component(
				'add-to-cart-button',
				null,
				[
					'product_id'         => $product->get_id(),
					'icon'               => true,
					'text'               => __( 'Add to quote', 'one-novanta-theme' ),
					'wrapper_attributes' => one_novanta_get_wrapper_attributes(
						[
							'id'    => [ 'single-product-add-to-cart-button' ],
							'class' => [ 'single_add_to_cart_button' ],
						]
					),
				],
			);

			do_action( 'woocommerce_after_add_to_cart_button' );
			?>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
