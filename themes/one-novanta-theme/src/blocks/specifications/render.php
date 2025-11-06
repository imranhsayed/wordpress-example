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

// Get the button block attributes.
$wrapper_attributes = get_block_wrapper_attributes();

$caption = ( isset( $attributes['figcaption'] ) && is_string( $attributes['figcaption'] ) ) ? $attributes['figcaption'] : '';

// Render component.
Template::render_component(
	'table',
	null,
	[
		'headers'          => [
			__( 'Specification', 'one-novanta-theme' ),
			__( 'Value', 'one-novanta-theme' ),
		],
		'rows'             => $content,
		'caption'          => $caption,
		'background_color' => 'secondary',
	],
);
