<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

use OneNovanta\Controllers\Common\Template;

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! isset( $attributes ) ) {
	$attributes = [];
}

if ( ! isset( $available_variations ) ) {
	$available_variations = '';
}

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );

if ( empty( $variations_json ) ) {
	$variations_json = '';
}

$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
$sku             = $product->get_sku();

// Get speak to our experts URL.
$speak_to_our_experts_url = one_novanta_get_speak_our_expert_url();

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="variations_form cart is_variable" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'one-novanta-theme' ) ) ); ?></p>
		<?php else : ?>
			<table class="variations" cellspacing="0" role="presentation">
				<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php one_novanta_kses_post_e( wc_attribute_label( $attribute_name ) ); // WPCS: XSS ok. ?></label></th>
						<td class="value">
							<?php
							wc_dropdown_variation_attribute_options(
								array(
									'options'   => $options,
									'attribute' => $attribute_name,
									'product'   => $product,
								)
							);
							/**
							 * Filters the reset variation button.
							 *
							 * @since 2.5.0
							 *
							 * @param string  $button The reset variation button HTML.
							 */
							echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'one-novanta-theme' ) . '">' . esc_html__( 'Clear', 'one-novanta-theme' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
			<?php do_action( 'woocommerce_after_variations_table' ); ?>

			<div class="single_variation_wrap">
				<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );
				?>

				<div class="woocommerce-variation single_variation" role="alert" aria-relevant="additions"></div>

				<div class="wp-block-woocommerce-product-meta">
					<div class="product-details__meta sku">
						<span class="wp-block-post-terms__prefix"><?php esc_html_e( 'Model Number: ', 'one-novanta-theme' ); ?></span>
						<span class="sku"><?php echo $sku ? esc_html( $sku ) : esc_html__( 'N/A', 'one-novanta-theme' ); ?></span>
					</div>
				</div>

				<div class="woocommerce-variation-add-to-cart variation_buttons">
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

					<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="variation_id" class="variation_id" value="0" />
				</div>

				<?php

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
