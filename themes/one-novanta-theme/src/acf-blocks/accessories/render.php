<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Check if it's a preview in gutenberg.
$is_preview = ! empty( $is_preview );

// Get the accessories field.
$accessories = get_field( 'accessories' );

// Bail out if there aren't any data.
if ( empty( $accessories ) || ! is_array( $accessories ) ) {
	// Check if it's a preview in gutenberg.
	if ( $is_preview ) {
		// Show a message in the preview.
		echo '<div class="acf-block-fields acf-fields"><div class="acf-field"><label>' . esc_html__( 'No accessories found. Please select any accessory.', 'one-novanta-theme' ) . '</label></div></div>';
	}

	// Bail out.
	return;
}

// Product list.
$table_rows = [];

// Loop through the accessories and get the product data.
foreach ( $accessories as $accessory ) {
	// Get the product data.
	$product = wc_get_product( $accessory );

	// Check if the product is valid.
	if ( empty( $product ) ) {
		continue;
	}

	$gallery_ids = $product->get_gallery_image_ids();

	if ( ! empty( $gallery_ids ) && is_array( $gallery_ids ) ) {
		$product_image = $gallery_ids[0];
	}

	// Add the product data to the rows.
	$table_rows[] = [
		'image_id' => $product_image ?? 0,
		'content'  => [
			$product->get_sku(),
			$product->get_short_description(),
			Template::get_component(
				'add-to-cart-button',
				null,
				[
					'product_id' => $product->get_id(),
				]
			),
		],
	];
}

$wrapper_attributes = get_block_wrapper_attributes();

// Render the component.
Template::render_component(
	'compare-model-table',
	null,
	[
		'headers'            => [
			__( 'Part Number', 'one-novanta-theme' ),
			__( 'Description', 'one-novanta-theme' ),
			'',
		],
		'show_cta_button'    => false,
		'rows'               => $table_rows,
		'filter_by'          => 1,
		'filter_title'       => __( 'Part Number', 'one-novanta-theme' ),
		'wrapper_attributes' => $wrapper_attributes,
	],
);
