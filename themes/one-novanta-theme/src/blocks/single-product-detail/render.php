<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string $content The block content.
 * @var WP_Block $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

// Return if it is not a single page.
if ( ! is_singular() ) {
	return;
}

$current_post_id = get_the_ID();

// Return if the current single page is not of a product type.
if ( empty( $current_post_id ) ) {
	return;
}

$product_data = one_novanta_get_post( $current_post_id );

$is_deprecated     = false;
$new_product_title = '';
$new_product_url   = '';

if ( ! empty( $product_data ) && ! empty( $product_data['post_meta'] ) ) {

	if ( ! empty( $product_data['post_meta']['is_product_deprecated'] ) ) {
		$is_deprecated = $product_data['post_meta']['is_product_deprecated'];
	}

	if ( ! empty( $product_data['post_meta']['new_product_name'] ) ) {
		$new_product_title = $product_data['post_meta']['new_product_name'];
	}

	if ( ! empty( $product_data['post_meta']['new_product_url'] ) ) {
		$new_product_url = $product_data['post_meta']['new_product_url'];
	}
}

$deprecation_notice = __( 'Attention: This product has been discontinued.', 'one-novanta-theme' );

/**
 * If new product title and URL are set, create a description with a link.
 * Otherwise, use the static notice.
 */
if ( ! empty( $new_product_title ) && ! empty( $new_product_url ) ) {
	$deprecation_notice = sprintf(
	/* translators: %1$s: New product title, %2$s: New product URL */
		__( 'Attention: This product has been discontinued. An upgraded product is <a href=\'%1$s\'><strong>%2$s</strong></a>.', 'one-novanta-theme' ),
		esc_url( $new_product_url ),
		esc_html( $new_product_title ),
	);
}

if ( $is_deprecated ) {
	one_novanta_kses_post_e(
		render_block(
			[
				'blockName' => 'one-novanta/notice',
				'attrs'     => [
					'content' => one_novanta_kses_post( $deprecation_notice ),
				],
			]
		)
	);
}

one_novanta_kses_post_e(
	render_block(
		[
			'blockName' => 'core/pattern',
			'attrs'     => [
				'slug' => 'one-novanta-theme/product',
			],
		]
	)
);
