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

use OneNovanta\Controllers\Common\Template;

// Only continue if any of the row value is non-empty.
if ( empty( $attributes ) || ( empty( $attributes['label'] ) && empty( $attributes['valueMetric'] ) ) ) {
	return;
}

// Get the button block attributes.
$label        = is_string( $attributes['label'] ) ? $attributes['label'] : '';
$value_metric = is_string( $attributes['valueMetric'] ) ? $attributes['valueMetric'] : '';

$row = [ $label, $value_metric ];

// Render component.
Template::render_component(
	'table',
	'row',
	[
		'row' => $row,
	]
);
