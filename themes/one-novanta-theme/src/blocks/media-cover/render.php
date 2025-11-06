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

use OneNovanta\Controllers\Common\Template;

// Return if required parameters are not available.
if ( empty( $attributes ) || ! is_array( $attributes ) || ! isset( $attributes['imageID'] ) ) {
	return;
}

// Get the media-cover block attributes.
$wrapper_attributes = get_block_wrapper_attributes();

// Generated block content.
$render_content = sprintf(
	'<p>%1$s</p>%2$s',
	$attributes['description'],
	$content,
);

// Render block.
Template::render_component(
	'media-cover',
	null,
	[
		'image_id'           => $attributes['imageID'],
		'content_align'      => $attributes['contentAlignment'],
		'content_width'      => $attributes['contentWidth'],
		'heading'            => $attributes['heading'],
		'content'            => $render_content,
		'wrapper_attributes' => $wrapper_attributes,
	],
);
