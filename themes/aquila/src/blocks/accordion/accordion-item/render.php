<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 * The following variables are exposed to the file:
 *    $attributes (array): The block attributes.
 *    $content (string): The block default content.
 *    $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use Aquila\Theme\Template;

$open_by_default = empty( $attributes['openByDefault'] ) ? 'no' : 'yes';
$accordion_title = $attributes['title'] ?? '';

// Render inner blocks content
// When using InnerBlocks.Content in save(), WordPress saves the inner blocks HTML
// That HTML should be available in $content, but if empty, render inner blocks manually
if ( empty( trim( $content ) ) && ! empty( $block->inner_blocks ) ) {
	$inner_content = '';
	foreach ( $block->inner_blocks as $inner_block ) {
		$inner_content .= $inner_block->render();
	}
	$content = $inner_content;
}

// If still empty, try accessing inner content directly from $block
if ( empty( trim( $content ) ) && isset( $block->inner_content ) && is_array( $block->inner_content ) ) {
	$content = '';
	foreach ( $block->inner_content as $inner_item ) {
		if ( is_string( $inner_item ) ) {
			$content .= $inner_item;
		} elseif ( $inner_item instanceof WP_Block ) {
			$content .= $inner_item->render();
		}
	}
}

Template::render_component(
	'accordion',
	'item',
	[
		'open_by_default' => $open_by_default,
		'title'           => $accordion_title,
		'content'         => $content,
	]
);
