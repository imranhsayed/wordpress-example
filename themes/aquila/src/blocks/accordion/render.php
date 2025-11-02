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

//echo '<pre/>';
//print_r('hisss');
//print_r($attributes);
//print_r($content);
//print_r($block);

// If no content is provided, return.
if ( empty( $content ) ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes();
// Get the accordion component.
\Aquila\Theme\Template::render_component(
	'accordion',
	null,
	[
		'content'            => $content,
		'wrapper_attributes' => $wrapper_attributes ?? '',
	],
);
