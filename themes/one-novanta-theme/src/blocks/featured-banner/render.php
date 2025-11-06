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
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

// Return if required parameters are not available.
if ( empty( $attributes ) || ! is_array( $attributes ) ) {
	return;
}

$is_dynamic = $attributes['isDynamic'] ?? false;

if ( $is_dynamic ) {
	require_once untrailingslashit( ONE_NOVANTA_THEME_DIR ) . '/src/blocks/featured-banner/renderer/dynamic.php';
	return;
}

require_once untrailingslashit( ONE_NOVANTA_THEME_DIR ) . '/src/blocks/featured-banner/renderer/static.php';
