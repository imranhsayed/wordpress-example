<?php
/**
 * PHP file to render the block on server to show on the front end.
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

use OneNovanta\Controllers\Common\Template;

if (
	! function_exists( 'ATI\WooCommerce\get_default_variation' ) ||
	! function_exists( 'ATI\WooCommerce\get_rest_variation_data' )
) {
	return;
}

// Get the current post ID.
$the_post_id = get_the_ID();

// Bail out if the post ID is not set.
if ( empty( $the_post_id ) ) {
	return;
}

// Initialize content.
$content = '';

// Get Default Variation ID.
$default_variation_id = \ATI\WooCommerce\get_default_variation( $the_post_id );

// Check if the default variation ID is not empty.
if ( ! empty( $default_variation_id ) ) {
	// Get the default variation data.
	$variation = \ATI\WooCommerce\get_rest_variation_data( $default_variation_id );

	// Render content.
	$content = $variation['post_content'] ?? '';
}

// Render component.
Template::render_component(
	'product-variation-content',
	null,
	[
		'content' => $content,
	]
);
