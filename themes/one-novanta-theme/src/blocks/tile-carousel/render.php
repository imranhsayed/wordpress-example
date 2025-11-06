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
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

// Get the button block attributes.
$wrapper_attributes = get_block_wrapper_attributes();

$slides = array();

// Iterate over innerblocks, and add all it's attributes to the $slides array.
foreach ( $block->inner_blocks as $inner_block ) {
	$slides[] = $inner_block->attributes;
}

// Render Tile Carousel component.
Template::render_component(
	'tile-carousel',
	null,
	array(
		...$attributes,
		'content'            => $content,
		'wrapper_attributes' => $wrapper_attributes,
	),
);
